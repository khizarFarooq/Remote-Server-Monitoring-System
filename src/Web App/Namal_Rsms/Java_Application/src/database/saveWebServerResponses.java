package database;

import alertAgent.*;
import server.server;
import structures.*;
import java.sql.*;
import java.util.ArrayList;

public class saveWebServerResponses {
    public static ArrayList<Service> webServer_MainService = new ArrayList<>();
    WebServer_Service webServer_service;
    Connection con;
    Statement stmt;
    emailAlert emailAlert = new emailAlert();
    soundAlert soundAlert=new soundAlert();
    int serverId, server_port;
    PortSubService portSubService = new PortSubService();
    PingSubService pingSubService = new PingSubService();
    WebServer_TestingSubService webServer_testingSubService = new WebServer_TestingSubService();
    String hostIp, serverPort, webUrl, pingService, portService, httpsService, monitoringConfig, normalMinutes, problemMinutes, retryNo, pingServiceTable, portServiceTable, httpsRequestServiceTable;

    public void runWebServerServices(String[] webServerInfo, String configurationSource) {

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
            webServer_service = new WebServer_Service();
            hostIp = webServerInfo[3];
            serverPort = webServerInfo[4];
            server_port = Integer.parseInt(serverPort);
            webUrl = webServerInfo[5];
            pingService = webServerInfo[6];
            portService = webServerInfo[7];
            httpsService = webServerInfo[8];
            monitoringConfig = webServerInfo[9];
            normalMinutes = webServerInfo[10];
            problemMinutes = webServerInfo[11];
            retryNo = webServerInfo[12];
            pingServiceTable = "_webserver_ping_service";
            portServiceTable = "_webserver_port_service";
            httpsRequestServiceTable = "_webserver_https_request_service";
            if (configurationSource.equals("databaseConfigurations")) {
                if (monitoringConfig.equals("start")) {
                    if (pingService.equals("yes")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        webServer_service.addSubService(pingSService);
                    }
                    if (portService.equals("yes")) {
                        PortSubService portSService = new PortSubService(hostIp, server_port, normalMinutes, retryNo);
                        webServer_service.addSubService(portSService);
                    }
                    if (httpsService.equals("yes")) {
                        WebServer_TestingSubService webServer_testingSubService = new WebServer_TestingSubService(webUrl, normalMinutes, retryNo);
                        webServer_service.addSubService(webServer_testingSubService);
                    }

                    webServer_MainService.add(webServer_service);
                    webServer_service.startService();
                    getwebServerStatus();
                }
                if (monitoringConfig.equals("pause")) {
                    if (pingService.equals("no")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        webServer_service.addSubService(pingSService);
                    }
                    if (portService.equals("no")) {
                        PortSubService portSService = new PortSubService(hostIp, server_port, normalMinutes, retryNo);
                        webServer_service.addSubService(portSService);
                    }
                    if (httpsService.equals("no")) {
                        WebServer_TestingSubService webServer_testingSubService = new WebServer_TestingSubService(webUrl, normalMinutes, retryNo);
                        webServer_service.addSubService(webServer_testingSubService);
                    }

                    webServer_MainService.add(webServer_service);
                    webServer_service.startService();
                    getwebServerStatus();
                }
            }
            if (configurationSource.equals("runTimeConfigurations")) {
                if (monitoringConfig.equals("pause")) {
                    for (Service service : webServer_MainService
                            ) {
                        service.stopService();
                    }
                    webServer_MainService.clear();
                    fetchWebServerConfig();
                }
                if (monitoringConfig.equals("start")) {
                    for (Service service : webServer_MainService
                            ) {
                        service.stopService();
                    }
                    webServer_MainService.clear();
                    fetchWebServerConfig();
                }
            }

        } catch (Exception e) {
            System.out.println(e);
        }
    }

    public void fetchWebServerConfig() {
        try {
            // our SQL SELECT query.
            String selectQuery = "SELECT * FROM web_server_info;";
            // execute the query, and get a java resultset
            ResultSet result = stmt.executeQuery(selectQuery);
            while (result.next()) {
                webServer_service = new WebServer_Service();
                monitoringConfig = result.getString("Monitoring_config");
                hostIp = result.getString("Host_ip");
                long ip = Long.parseLong(hostIp);
                server server = new server();
                hostIp = server.decimalToIp(ip);
                serverPort = result.getString("Server_port");
                server_port = Integer.parseInt(serverPort);
                webUrl = result.getString("Web_url");
                pingService = result.getString("Ping_service");
                portService = result.getString("Port_service");
                httpsService = result.getString("Https_service");
                if (monitoringConfig.equals("start")) {
                    if (pingService.equals("yes")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        webServer_service.addSubService(pingSService);
                    }
                    if (portService.equals("yes")) {
                        PortSubService portSService = new PortSubService(hostIp, server_port, normalMinutes, retryNo);
                        webServer_service.addSubService(portSService);
                    }
                    if (httpsService.equals("yes")) {
                        WebServer_TestingSubService webServer_testingSubService = new WebServer_TestingSubService(webUrl, normalMinutes, retryNo);
                        webServer_service.addSubService(webServer_testingSubService);
                    }
//                        webServer_service.id=serverId+"WS";
                    webServer_MainService.add(webServer_service);
                    webServer_service.startService();
                    getwebServerStatus();
                }

                if (monitoringConfig.equals("pause")) {

                    if (pingService.equals("no")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        webServer_service.addSubService(pingSService);
                    }
                    if (portService.equals("no")) {
                        PortSubService portSService = new PortSubService(hostIp, server_port, normalMinutes, retryNo);
                        webServer_service.addSubService(portSService);
                    }
                    if (httpsService.equals("no")) {
                        WebServer_TestingSubService webServer_testingSubService = new WebServer_TestingSubService(webUrl, normalMinutes, retryNo);
                        webServer_service.addSubService(webServer_testingSubService);
                    }
//                        webServer_service.id=serverId+"WS";
                    webServer_MainService.add(webServer_service);
                    webServer_service.startService();
                    getwebServerStatus();
                }


            }
        } catch (Exception ex) {
            System.out.println(ex);
        }

    }

    public void getwebServerStatus() {
        webServer_service.addListener(new Service.ProgressListener() {
            @Override
            public void getProgress(ServicePacket packet) {
                if (packet.getType() == ServerTypes.WEB_SERVER) {
                    System.out.println(packet.getSubServiceType());
                    if (packet.getSubServiceType() == SubServicesTypes.HOST_AVAILABILITY) {
                        PingPacket pingPacket = (PingPacket) packet.getSubServicePacket();
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
                        String selectQuery = "SELECT ID FROM web_server_info WHERE Host_ip='" + hostIp + "';";
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
                            System.out.println("Packet Type is " + pingPacket.getType());

                            pingSubService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(pingPacket.getHostIp(),0,packet.getType(),SubServicesTypes.HOST_AVAILABILITY,pingPacket.getType().toString(),timeStamp);
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
                            System.out.println("Packet Type is " + pingPacket.getType());

                            pingSubService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(pingPacket.getHostIp(),0,packet.getType(),SubServicesTypes.HOST_AVAILABILITY,pingPacket.getType().toString(),timeStamp);
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
                        String timeStamp = sap.getTimeStamp();
                        server server = new server();
                        String hostIp = Long.toString(server.ipToLong(sap.getHostIp()));
                        String selectQuery = "SELECT ID FROM WEB_server_info WHERE Host_ip='" + hostIp + "';";
                        try {
                            ResultSet result = stmt.executeQuery(selectQuery);
                            while (result.next()) {
                                serverId = result.getInt("ID");
                            }
                        } catch (Exception e) {

                        }
                        if (status.equals("Time Out") || status.equals("Unknown Host")) {
                            System.out.println("It is web server port availability status :" + sap.isAvailability());
                            portSubService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(sap.getHostIp(),sap.getServerPort(),packet.getType(),SubServicesTypes.SERVER_AVAILABILITY, status, timeStamp);
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
                    if (packet.getSubServiceType() == SubServicesTypes.WEB_SERVER_TESTING) {
                        HttpsPacket httpsPacket = (HttpsPacket) packet.getSubServicePacket();
                        int responseCode = httpsPacket.getStatusResponseCode();
                        String timeStamp = httpsPacket.getTimeStamp();
                        HttpsPacket.packetType status = httpsPacket.getType();
                        server server = new server();
                        String hostIp = Long.toString(server.ipToLong(httpsPacket.getHostIp()));
                        String selectQuery = "SELECT ID FROM WEB_server_info WHERE Host_ip='" + hostIp + "';";
                        try {
                            ResultSet result = stmt.executeQuery(selectQuery);
                            while (result.next()) {
                                serverId = result.getInt("ID");
                            }
                        } catch (Exception e) {

                        }
                        if (status.equals("DOWN")) {

                            webServer_testingSubService.setRecheckDelay(problemMinutes);
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

    public static void main(String[] args) {

    }
}
