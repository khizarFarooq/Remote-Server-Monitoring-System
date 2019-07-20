package database;

import alertAgent.*;
import structures.*;
import server.*;

import java.sql.*;
import java.util.ArrayList;

public class saveProxyServerResponses {
    ProxyServer_Service proxyServer_service;
    Connection con;
    Statement stmt;
    static int retries;
    public static ArrayList<Service> proxyServer_MainService = new ArrayList<>();
    emailAlert emailAlert = new emailAlert();
    soundAlert soundAlert=new soundAlert();
    int serverId, port;
    PortSubService portSubService = new PortSubService();
    PingSubService pingSubService = new PingSubService();
    ProxyServer_TestingSubService proxyServer_testingSubService = new ProxyServer_TestingSubService();
    String hostIp, serverPort, webUrl, pingService, portService, httpsService, monitoringConfig, normalMinutes, problemMinutes, retryNo, pingServiceTable, portServiceTable, httpsRequestServiceTable;

    public void runProxyServerServices(String[] split, String configurationSource) {

        try {
            // create our mysql database connection
            String myDriver = "com.mysql.jdbc.Driver";
            //here namal_rsms is database name, root is username and password is nothing.
            String myUrl = "jdbc:mysql://localhost:3306/namal_rsms";
            Class.forName(myDriver);
            String userName = "root", password = "";
            con = DriverManager.getConnection(myUrl, userName, password);
            // create the java statement
            stmt = con.createStatement();
            //To run services of proxy Server according to admin configuration
            proxyServer_service = new ProxyServer_Service();
            hostIp = split[3];
            serverPort = split[4];
            port = Integer.parseInt(serverPort);
            webUrl = split[5];
            pingService = split[6];
            portService = split[7];
            httpsService = split[8];
            monitoringConfig = split[9];
            normalMinutes = split[10];
            problemMinutes = split[11];
            retryNo = split[12];
            pingServiceTable = "_proxy_server_ping_service";
            portServiceTable = "_proxy_server_port_service";
            httpsRequestServiceTable = "_proxy_server_https_request_service";
            if (configurationSource.equals("databaseConfigurations")) {
                if (monitoringConfig.equals("start")) {
                    if (pingService.equals("yes")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        proxyServer_service.addSubService(pingSService);
                    }
                    if (portService.equals("yes")) {
                        PortSubService portSService = new PortSubService(hostIp, port, normalMinutes, retryNo);
                        proxyServer_service.addSubService(portSService);
                    }
                    if (httpsService.equals("yes")) {
                        ProxyServer_TestingSubService proxyServer_testingSubService = new ProxyServer_TestingSubService(hostIp, port, webUrl, normalMinutes, retryNo);
                        proxyServer_service.addSubService(proxyServer_testingSubService);
                    }
                    proxyServer_MainService.add(proxyServer_service);
                    proxyServer_service.startService();
                    getProxyServerStatus();
                }
                if (monitoringConfig.equals("pause")) {
                    if (pingService.equals("no")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        proxyServer_service.addSubService(pingSService);
                    }
                    if (portService.equals("no")) {
                        PortSubService portSService = new PortSubService(hostIp, port, normalMinutes, retryNo);
                        proxyServer_service.addSubService(portSService);
                    }
                    if (httpsService.equals("no")) {
                        ProxyServer_TestingSubService proxyServer_testingSubService = new ProxyServer_TestingSubService(hostIp, port, webUrl, normalMinutes, retryNo);
                        proxyServer_service.addSubService(proxyServer_testingSubService);
                    }
                    proxyServer_MainService.add(proxyServer_service);
                    proxyServer_service.startService();
                    getProxyServerStatus();
                }
            }
            if (configurationSource.equals("runTimeConfigurations")) {
                if (monitoringConfig.equals("pause")) {
                    for (Service service : proxyServer_MainService
                            ) {
                        service.stopService();
                    }
                    proxyServer_MainService.clear();
                    fetchProxyServersInfo();
                }
                if (monitoringConfig.equals("start")) {
                    for (Service service : proxyServer_MainService
                            ) {
                        service.stopService();
                    }
                    proxyServer_MainService.clear();
                    fetchProxyServersInfo();
                }
            }
        } catch (Exception e) {
            System.out.println(e);
        }
    }

    public void getProxyServerStatus() {


        proxyServer_service.addListener(new Service.ProgressListener() {
            @Override
            public void getProgress(ServicePacket packet) {
                if (packet.getType() == ServerTypes.PROXY_SERVER) {
                    System.out.println(packet.getSubServiceType());
                    if (packet.getSubServiceType() == SubServicesTypes.HOST_AVAILABILITY) {
                        PingPacket pingPacket = (PingPacket) packet.getSubServicePacket();
                        System.out.println("Proxy server ping status :" + pingPacket.getType().toString());
                        String replyFrom = pingPacket.getServerName();
                        String receivedPackets = pingPacket.getNoOfReceivedPackets();
                        String lostPackets = pingPacket.getNoOfLostPackets();
                        String sentPackets = pingPacket.getNoOfSentPackets();
                        String ttl = pingPacket.getTTL();
                        String rttMin = pingPacket.getMinRTT();
                        String rttMax = pingPacket.getMaxRTT();
                        String rttAve = pingPacket.getAvgRTT();
                        String timeStamp = pingPacket.getTimeStamp();
                        String error = pingPacket.getError();
                        server server = new server();
                        String hostIp = Long.toString(server.ipToLong(pingPacket.getHostIp()));
                        String selectQuery = "SELECT ID FROM proxy_server_info WHERE Host_ip='" + hostIp + "';";
                        try {
                            ResultSet result = stmt.executeQuery(selectQuery);
                            while (result.next()) {
                                serverId = result.getInt("ID");
                            }
                        } catch (Exception e) {

                        }
                        if (pingPacket.getType().toString() == "OK") {
                            String populateQuery = "INSERT into " + serverId + pingServiceTable + "(id,reply_From,ttl,rtt_Min,rtt_Max,rtt_Ave,error,sent,received,lost,status,time_Stamp)" + " VALUES (DEFAULT,'" + replyFrom + "','" + ttl + "','" + rttMin + "','" + rttMax + "','" + rttAve + "','null', '" + sentPackets + "','" + receivedPackets + "','" + lostPackets + "','OK','" + timeStamp + "');";
                            try {
                                PreparedStatement preparedStatement = con.prepareStatement(populateQuery);
                                preparedStatement.executeUpdate();
                            } catch (SQLException e) {
                                e.printStackTrace();
                            }
                        }
                        if (pingPacket.getType().toString() == "UNREACHABLE") {

                            pingSubService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(pingPacket.getHostIp(), 0, packet.getType(), SubServicesTypes.HOST_AVAILABILITY, pingPacket.getType().toString(), timeStamp);
                            soundAlert.throwSoundAlert();


                            String populateQuery = "INSERT into " + serverId + pingServiceTable + "(id,reply_From,ttl,rtt_Min,rtt_Max,rtt_Ave,error,sent,received,lost,status,time_Stamp)" + " VALUES (DEFAULT,'" + replyFrom + "','null','null','null','null','" + error + "','" + sentPackets + "', '" + receivedPackets + "','" + lostPackets + "','UNREACHABLE','" + timeStamp + "');";
                                try {
                                    PreparedStatement preparedStatement = con.prepareStatement(populateQuery);
                                    preparedStatement.executeUpdate();
                                } catch (SQLException e) {
                                    e.printStackTrace();
                                }
                        }
                        if (pingPacket.getType().toString() == "TIMEOUT") {

                            pingSubService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(pingPacket.getHostIp(), 0, packet.getType(), SubServicesTypes.HOST_AVAILABILITY, pingPacket.getType().toString(), timeStamp);
                            soundAlert.throwSoundAlert();
                            String populateQuery = "INSERT into " + serverId + pingServiceTable + "(id,reply_From,ttl,rtt_Min,rtt_Max,rtt_Ave,error,sent,received,lost,status,time_Stamp)" + " VALUES (DEFAULT,'null','null','null','null','null','" + error + "','" + sentPackets + "', '" + receivedPackets + "','" + lostPackets + "','TIMEOUT','" + timeStamp + "');";
                            try {
                                PreparedStatement preparedStatement = con.prepareStatement(populateQuery);
                                preparedStatement.executeUpdate();
                            } catch (SQLException e) {
                                e.printStackTrace();
                            }
                        }
                    }
                    if (packet.getSubServiceType() == SubServicesTypes.SERVER_AVAILABILITY) {
                        ServerAvailabilityPacket sap = (ServerAvailabilityPacket) packet.getSubServicePacket();
                        String status = sap.isAvailability();
                        System.out.println("Proxy serve port availability status :" + status);
                        String timeStamp = sap.getTimeStamp();
                        server server = new server();
                        String hostIp = Long.toString(server.ipToLong(sap.getHostIp()));
                        String selectQuery = "SELECT ID FROM proxy_server_info WHERE Host_ip='" + hostIp + "';";
                        try {
                            ResultSet result = stmt.executeQuery(selectQuery);
                            while (result.next()) {
                                serverId = result.getInt("ID");
                            }
                        } catch (Exception e) {

                        }
                        if (status.equals("Time Out") || status.equals("Unknown Host")) {

                            portSubService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(sap.getHostIp(), sap.getServerPort(), packet.getType(), SubServicesTypes.SERVER_AVAILABILITY, status, timeStamp);
                            soundAlert.throwSoundAlert();
                        }

                        String populateQuery = "INSERT into " + serverId + portServiceTable + "(id,status,time_Stamp)" + " VALUES (DEFAULT,'" + status + "','" + timeStamp + "');";
                            try {
                                PreparedStatement preparedStatement = con.prepareStatement(populateQuery);
                                preparedStatement.executeUpdate();
                            } catch (SQLException e) {
                                e.printStackTrace();
                            }

                    }
                    if (packet.getSubServiceType() == SubServicesTypes.PROXY_SERVER_TESTING) {
                        HttpsPacket httpsPacket = (HttpsPacket) packet.getSubServicePacket();
                        int responseCode = httpsPacket.getStatusResponseCode();
                        String timeStamp = httpsPacket.getTimeStamp();
                        HttpsPacket.packetType status = httpsPacket.getType();
                        server server = new server();
                        String hostIp = Long.toString(server.ipToLong(httpsPacket.getHostIp()));
                        String selectQuery = "SELECT ID FROM proxy_server_info WHERE Host_ip='" + hostIp + "';";
                        try {
                            ResultSet result = stmt.executeQuery(selectQuery);
                            while (result.next()) {
                                serverId = result.getInt("ID");
                            }
                        } catch (Exception e) {

                        }
                        if (status.equals("DOWN")) {
                            proxyServer_testingSubService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(httpsPacket.getHostIp(), 0, packet.getType(), packet.getSubServiceType(), status.toString(), timeStamp);
                            soundAlert.throwSoundAlert();
                        }

                        String populateQuery = "INSERT into " + serverId + httpsRequestServiceTable + "(id,responseCode,status,time_Stamp)" + "VALUES (DEFAULT,'" + responseCode + "','" + status + "','" + timeStamp + "');";
                            try {
                                PreparedStatement preparedStatement = con.prepareStatement(populateQuery);
                                preparedStatement.executeUpdate();
                            } catch (SQLException e) {
                                e.printStackTrace();
                            }
                    }
                }
            }
        });
    }

    public void fetchProxyServersInfo() {
        try {

            // our SQL SELECT query.
            String selectQuery = "SELECT * FROM proxy_server_info;";
            // execute the query, and get a java resultset
            ResultSet result = stmt.executeQuery(selectQuery);
            while (result.next()) {
                proxyServer_service = new ProxyServer_Service();
                monitoringConfig = result.getString("Monitoring_config");
                hostIp = result.getString("Host_ip");
                long ip = Long.parseLong(hostIp);
                server server = new server();
                hostIp = server.decimalToIp(ip);
                serverPort = result.getString("Server_port");
                port = Integer.parseInt(serverPort);
                webUrl = result.getString("Web_url");
                pingService = result.getString("Ping_service");
                portService = result.getString("Port_service");
                httpsService = result.getString("Https_service");
                if (monitoringConfig.equals("start")) {
                    if (pingService.equals("yes")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        proxyServer_service.addSubService(pingSService);
                    }
                    if (portService.equals("yes")) {
                        PortSubService portSService = new PortSubService(hostIp, port, normalMinutes, retryNo);
                        proxyServer_service.addSubService(portSService);
                    }
                    if (httpsService.equals("yes")) {
                        ProxyServer_TestingSubService proxyServer_testingSubService = new ProxyServer_TestingSubService(hostIp, port, webUrl, normalMinutes, retryNo);
                        proxyServer_service.addSubService(proxyServer_testingSubService);
                    }
//                        proxyServer_service.id=serverId+"PS";
                    proxyServer_MainService.add(proxyServer_service);
                    proxyServer_service.startService();
                    getProxyServerStatus();

                }

                if (monitoringConfig.equals("pause")) {

                    if (pingService.equals("no")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        proxyServer_service.addSubService(pingSService);
                    }
                    if (portService.equals("no")) {
                        PortSubService portSService = new PortSubService(hostIp, port, normalMinutes, retryNo);
                        proxyServer_service.addSubService(portSService);
                    }
                    if (httpsService.equals("no")) {
                        ProxyServer_TestingSubService proxyServer_testingSubService = new ProxyServer_TestingSubService(hostIp, port, webUrl, normalMinutes, retryNo);
                        proxyServer_service.addSubService(proxyServer_testingSubService);
                    }
//                        proxyServer_service.id=serverId+"PS";
                    proxyServer_MainService.add(proxyServer_service);
                    proxyServer_service.startService();
                    getProxyServerStatus();

                }


            }
        } catch (Exception ex) {
            System.out.println(ex);
        }
    }

    public static void main(String[] args) {

    }
}
