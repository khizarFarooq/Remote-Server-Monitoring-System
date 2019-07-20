package server;

import java.io.IOException;
import java.io.OutputStream;
import java.net.InetSocketAddress;
import java.sql.*;
import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpServer;
import database.saveDNSResponses;
import database.saveProxyServerResponses;
import database.saveWebServerResponses;
import static database.saveDNSResponses.DNS_MainService;
import static database.saveProxyServerResponses.proxyServer_MainService;
import static database.saveWebServerResponses.webServer_MainService;

public class server {
    public static void main(String[] args) throws Exception {
        String[] serverInfo = new String[100];
        saveDNSResponses saveDNSResponses = new saveDNSResponses();
        DNS_MainService.clear();
        saveProxyServerResponses saveProxyServerResponses = new saveProxyServerResponses();
        proxyServer_MainService.clear();
        saveWebServerResponses saveWebServerResponses = new saveWebServerResponses();
        webServer_MainService.clear();


        try {
            // create our mysql database connection
            String myDriver = "com.mysql.jdbc.Driver";
            //here namal_rsms is database name, root is username and password is nothing.
            String myUrl = "jdbc:mysql://localhost:3306/namal_rsms";
            Class.forName(myDriver);
            String userName = "root", password = "";
            Connection con = DriverManager.getConnection(myUrl, userName, password);
            // create the java statement
            Statement stmt = con.createStatement();
            // our SQL SELECT query to collect dns info.
            String selectQuery = "SELECT * FROM dns_info;";
            // execute the query, and get a java resultset
            ResultSet result = stmt.executeQuery(selectQuery);
            while (result.next()) {
                serverInfo[2] = result.getString("ID");
                serverInfo[3] = result.getString("Host_ip");
                long ip = Long.parseLong(serverInfo[3]);
                server server = new server();
                serverInfo[3] = server.decimalToIp(ip);
                serverInfo[4] = result.getString("Server_port");
                serverInfo[5] = result.getString("FQDN");
                serverInfo[6] = result.getString("Ping_service");
                serverInfo[7] = result.getString("Port_service");
                serverInfo[8] = result.getString("DNS_resolution");
                serverInfo[9] = result.getString("Monitoring_config");
                serverInfo[10] = result.getString("Normal_checking_time");
                serverInfo[11] = result.getString("Recheck_time");
                serverInfo[12] = result.getString("Upto_time");
                saveDNSResponses.runDNSServices(serverInfo, "databaseConfigurations");
                //System.out.println("send "+serverInfo[3]);
            }
            // our SQL SELECT query to collect proxy server info.
            selectQuery = "SELECT * FROM proxy_server_info;";
            // execute the query, and get a java resultset
            result = stmt.executeQuery(selectQuery);
            while (result.next()) {
                serverInfo[2] = result.getString("ID");
                serverInfo[3] = result.getString("Host_ip");
                long ip = Long.parseLong(serverInfo[3]);
                server server = new server();
                serverInfo[3] = server.decimalToIp(ip);
                serverInfo[4] = result.getString("Server_port");
                serverInfo[5] = result.getString("Web_url");
                serverInfo[6] = result.getString("Ping_service");
                serverInfo[7] = result.getString("Port_service");
                serverInfo[8] = result.getString("Https_service");
                serverInfo[9] = result.getString("Monitoring_config");
                serverInfo[10] = result.getString("Normal_checking_time");
                serverInfo[11] = result.getString("Recheck_time");
                serverInfo[12] = result.getString("Upto_time");
                saveProxyServerResponses.runProxyServerServices(serverInfo, "databaseConfigurations");
            }
            // our SQL SELECT query to collect web server info.
            selectQuery = "SELECT * FROM web_server_info;";
            // execute the query, and get a java resultset
            result = stmt.executeQuery(selectQuery);
            while (result.next()) {
                serverInfo[2] = result.getString("ID");
                serverInfo[3] = result.getString("Host_ip");
                long ip = Long.parseLong(serverInfo[3]);
                server server = new server();
                serverInfo[3] = server.decimalToIp(ip);
                serverInfo[4] = result.getString("Server_port");
                serverInfo[5] = result.getString("Web_url");
                serverInfo[6] = result.getString("Ping_service");
                serverInfo[7] = result.getString("Port_service");
                serverInfo[8] = result.getString("Https_service");
                serverInfo[9] = result.getString("Monitoring_config");
                serverInfo[10] = result.getString("Normal_checking_time");
                serverInfo[11] = result.getString("Recheck_time");
                serverInfo[12] = result.getString("Upto_time");
                saveWebServerResponses.runWebServerServices(serverInfo, "databaseConfigurations");
            }

        } catch (Exception exception) {
            System.err.println(exception);
        }

        HttpServer server = HttpServer.create(new InetSocketAddress(8000), 0);
        server.createContext("/", new MyHandler());
        server.setExecutor(null); // creates a default executor
        server.start();
    }

    static class MyHandler implements HttpHandler {
        String action;

        @Override
        public void handle(HttpExchange t) throws IOException {
            String serverInfo = t.getRequestURI().toString();
            // System.out.println(serverInfo);
            String[] split = serverInfo.split("/");
            action = split[1];
            //System.out.println(action);
            try {
                // create our mysql database connection
                String myDriver = "com.mysql.jdbc.Driver";
                //here namal_rsms is database name, root is username and password is nothing.
                String myUrl = "jdbc:mysql://localhost:3306/namal_rsms";
                Class.forName(myDriver);
                String userName = "root", password = "";
                Connection con = DriverManager.getConnection(myUrl, userName, password);
                // create the java statement
                Statement stmt = con.createStatement();
                //To run services of proxy Server according to admin configuration
                if (action.equals("proxyServerRegistration") || action.equals("updateProxyServer")) {
                    saveProxyServerResponses saveProxyServerResponses = new saveProxyServerResponses();
                    saveProxyServerResponses.runProxyServerServices(split, "runTimeConfigurations");
                }

                // To run services of Web Server according to admin configuration
                if (action.equals("webServerRegistration") || action.equals("updateWebServer")) {
                    saveWebServerResponses saveWebServerResponses = new saveWebServerResponses();
                    saveWebServerResponses.runWebServerServices(split, "runTimeConfigurations");
                }
                //To run services of Domain Name Server according to admin configuration
                if (action.equals("dnsRegistration") || action.equals("updateDns")) {
                    saveDNSResponses saveDNSResponse = new saveDNSResponses();
                    saveDNSResponse.runDNSServices(split, "runTimeConfigurations");
                }
            } catch (Exception e) {
                System.out.println(e);
            }
            String value = t.getRequestURI().toString();
            t.sendResponseHeaders(200, value.length());
            OutputStream os = t.getResponseBody();
            os.write(value.getBytes());
            os.close();
        }
    }

    public String decimalToIp(long i) {
        return ((i >> 24) & 0xFF) +
                "." + ((i >> 16) & 0xFF) +
                "." + ((i >> 8) & 0xFF) +
                "." + (i & 0xFF);
    }

    public long ipToLong(String ipAddress) {

        String[] ipAddressInArray = ipAddress.split("\\.");

        long result = 0;
        for (int i = 0; i < ipAddressInArray.length; i++) {

            int power = 3 - i;
            int ip = Integer.parseInt(ipAddressInArray[i]);
            result += ip * Math.pow(256, power);

        }

        return result;
    }


}