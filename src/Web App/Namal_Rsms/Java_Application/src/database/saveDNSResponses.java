package database;

import alertAgent.*;
import structures.*;
import server.*;
import java.sql.*;
import java.util.ArrayList;

public class saveDNSResponses {
    public static ArrayList<Service> DNS_MainService = new ArrayList<>();
    emailAlert emailAlert = new emailAlert();
    soundAlert soundAlert=new soundAlert();
    PortSubService portSubService = new PortSubService();
    PingSubService pingSubService = new PingSubService();
    domainNameResolution_SubService domainNameResolution_subService = new domainNameResolution_SubService();
    DnsService dnsService;
    Statement stmt;
    Connection con;
    int serverId, port;
    String hostIp, serverPort, fqdn, pingService, portService, dnsResolutionService, monitoringConfig, normalMinutes, problemMinutes, retryNo, pingServiceTable, portServiceTable, dnsResolutionServiceTable;

    public void runDNSServices(String[] dnsInfo, String configurationSource) {
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
            //To run services of DNS according to admin configuration
            dnsService = new DnsService();
            hostIp = dnsInfo[3];
            //System.out.println("received :"+hostIp);
            serverPort = dnsInfo[4];
            port = Integer.parseInt(serverPort);
            fqdn = dnsInfo[5];
            pingService = dnsInfo[6];
            portService = dnsInfo[7];
            dnsResolutionService = dnsInfo[8];
            monitoringConfig = dnsInfo[9];
            normalMinutes = dnsInfo[10];
            problemMinutes = dnsInfo[11];
            retryNo = dnsInfo[12];
            pingServiceTable = "_dns_ping_service";
            portServiceTable = "_dns_port_service";
            dnsResolutionServiceTable = "_dns_domain_name_resolution_service";

            if (configurationSource.equals("databaseConfigurations")) {
                if (monitoringConfig.equals("start")) {
                    if (pingService.equals("yes")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        dnsService.addSubService(pingSService);
                    }
                    if (portService.equals("yes")) {
                        PortSubService portSService = new PortSubService(hostIp, port, normalMinutes, retryNo);
                        dnsService.addSubService(portSService);
                    }
                    if (dnsResolutionService.equals("yes")) {
                        String[] dnsQueryInfo = {"@" + hostIp, fqdn, serverPort, retryNo};
                        domainNameResolution_SubService domainNameResolution_subService = new domainNameResolution_SubService(dnsQueryInfo, normalMinutes);
                        dnsService.addSubService(domainNameResolution_subService);
                    }
                    DNS_MainService.add(dnsService);
                    dnsService.startService();
                    getDnsStatus();
                }
                if (monitoringConfig.equals("pause")) {

                    if (pingService.equals("no")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        dnsService.addSubService(pingSService);
                    }
                    if (portService.equals("no")) {
                        PortSubService portSService = new PortSubService(hostIp, port, normalMinutes, retryNo);
                        dnsService.addSubService(portSService);
                    }
                    if (dnsResolutionService.equals("no")) {
                        String[] dnsQueryInfo = {"@" + hostIp, fqdn, serverPort, retryNo};
                        domainNameResolution_SubService domainNameResolution_subService = new domainNameResolution_SubService(dnsQueryInfo, normalMinutes);
                        dnsService.addSubService(domainNameResolution_subService);
                    }
//                        dnsService.id=serverId+"DNS";
                    DNS_MainService.add(dnsService);
                    dnsService.startService();
                    getDnsStatus();
                }
            }
            if (configurationSource.equals("runTimeConfigurations")) {
                if (monitoringConfig.equals("start")) {
                    for (Service service : DNS_MainService
                            ) {
                        service.stopService();

                    }
                    DNS_MainService.clear();
                    fetchDnsConfig();
                }
                if (monitoringConfig.equals("pause")) {
                    for (Service service : DNS_MainService
                            ) {
                        service.stopService();

                    }
                    DNS_MainService.clear();
                    fetchDnsConfig();
                }
            }


        } catch (Exception e) {

        }
    }

    public void fetchDnsConfig() {
        try {
            // our SQL SELECT query.
            String selectQuery = "SELECT * FROM dns_info;";
            // execute the query, and get a java resultset
            ResultSet result = stmt.executeQuery(selectQuery);
            while (result.next()) {
                dnsService = new DnsService();
                monitoringConfig = result.getString("Monitoring_config");
                hostIp = result.getString("Host_ip");
                long ip = Long.parseLong(hostIp);
                server server = new server();
                hostIp = server.decimalToIp(ip);
                serverPort = result.getString("Server_port");
                fqdn = result.getString("FQDN");
                pingService = result.getString("Ping_service");
                portService = result.getString("Port_service");
                dnsResolutionService = result.getString("DNS_resolution");
                retryNo = result.getString("Upto_time");
                if (monitoringConfig.equals("start")) {

                    if (pingService.equals("yes")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        dnsService.addSubService(pingSService);

                    }
                    if (portService.equals("yes")) {
                        PortSubService portSService = new PortSubService(hostIp, port, normalMinutes, retryNo);
                        dnsService.addSubService(portSService);

                    }
                    if (dnsResolutionService.equals("yes")) {
                        String[] dnsQueryInfo = {"@" + hostIp, fqdn, serverPort, retryNo};
                        domainNameResolution_SubService domainNameResolution_subService = new domainNameResolution_SubService(dnsQueryInfo, normalMinutes);
                        dnsService.addSubService(domainNameResolution_subService);
                    }
//                        dnsService.id=serverId+"DNS";
                    DNS_MainService.add(dnsService);
                    dnsService.startService();
                    System.out.println("testing");
                    getDnsStatus();
                }

                if (monitoringConfig.equals("pause")) {

                    if (pingService.equals("no")) {
                        PingSubService pingSService = new PingSubService(hostIp, normalMinutes, retryNo);
                        dnsService.addSubService(pingSService);
                    }
                    if (portService.equals("no")) {
                        PortSubService portSService = new PortSubService(hostIp, port, normalMinutes, retryNo);
                        dnsService.addSubService(portSService);
                    }
                    if (dnsResolutionService.equals("no")) {
                        String[] dnsQueryInfo = {"@" + hostIp, fqdn, serverPort, retryNo};
                        domainNameResolution_SubService domainNameResolution_subService = new domainNameResolution_SubService(dnsQueryInfo, normalMinutes);
                        dnsService.addSubService(domainNameResolution_subService);
                    }

                    DNS_MainService.add(dnsService);
                    dnsService.startService();
                    getDnsStatus();

                }


            }
        } catch (Exception ex) {

        }
    }

    public void getDnsStatus() {
        dnsService.addListener(new Service.ProgressListener() {
            @Override
            public void getProgress(ServicePacket packet) {
                if (packet.getType() == ServerTypes.DNS) {
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
                        String selectQuery = "SELECT * FROM dns_info WHERE Host_ip='" + hostIp + "';";
                        try {
                            ResultSet result = stmt.executeQuery(selectQuery);
                            while (result.next()) {
                                serverId = result.getInt("ID");
                            }
                        } catch (Exception e) {

                        }
                        if (pingPacket.getType().toString() == "OK") {
                            System.out.println("ping packet of this ip " + hostIp);
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

                            pingSubService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(pingPacket.getHostIp(),0, packet.getType(), SubServicesTypes.HOST_AVAILABILITY, pingPacket.getType().toString(), timeStamp);
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

                        String selectQuery = "SELECT ID FROM dns_info WHERE Host_ip='" + hostIp + "';";
                        try {
                            ResultSet result=stmt.executeQuery(selectQuery);
                            while(result.next()){
                                serverId=result.getInt("ID");

                            }
                        }catch (Exception e){

                        }
                        if ((status.equals("Time Out") || status.equals("Unknown Host"))) {

                            System.out.println(sap.getHostIp() + " Server is not listening on this port " + sap.getServerPort());
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
                    if (packet.getSubServiceType() == SubServicesTypes.DNS_TESTING) {
                        DnsPacket dnsPacket = (DnsPacket) packet.getSubServicePacket();
                        String domainNameIp = dnsPacket.getDomainName_IP();
                        String response_Time = dnsPacket.getResponseTime();
                        String noOfretries = dnsPacket.getRetries();
                        String ttl = dnsPacket.getTTL();
                        String timeStamp = dnsPacket.getTimeStamp();
                        String status = dnsPacket.getStatus();
                        server server = new server();
                        String hostIp = Long.toString(server.ipToLong(dnsPacket.getHostIp()));
                        String selectQuery = "SELECT * FROM dns_info WHERE Host_ip='" + hostIp + "';";
                        try {
                            ResultSet result = stmt.executeQuery(selectQuery);
                            while (result.next()) {
                                serverId = result.getInt("ID");
                            }
                        } catch (Exception e) {

                        }
                        if (status.equals("Server failure")) {
                            domainNameResolution_subService.setRecheckDelay(problemMinutes);
                            emailAlert.sendEmailAlert(dnsPacket.getHostIp(),0,packet.getType(),SubServicesTypes.DNS_TESTING, status, timeStamp);
                            soundAlert.throwSoundAlert();
                        }
                        String populateQuery = "INSERT into " + serverId + dnsResolutionServiceTable + "(id,domainName_IP,response_Time,retries,ttl,status,time_Stamp)" + "VALUES (DEFAULT,'" + domainNameIp + "','" + response_Time + "','" + noOfretries + "','" + ttl + "','" + status + "','" + timeStamp + "');";
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
