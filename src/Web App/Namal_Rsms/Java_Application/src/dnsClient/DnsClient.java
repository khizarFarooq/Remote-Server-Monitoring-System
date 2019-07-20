package dnsClient;

import structures.DnsPacket;

import java.net.*;
import java.util.Arrays;
import java.util.List;
import java.util.ListIterator;

public class DnsClient {

    public QueryType queryType = QueryType.A;
    public int MAX_DNS_PACKET_SIZE = 512;
    private int timeout = 5000;
    private int maxRetries;
    String responseTime;
    String retries;
    private byte[] server = new byte[4];
    String address;
    private String name;
    private int port;
    public static String domainName_IP, status;
    public static String timeToLive;


    public DnsClient(String args[]) {
        String serverPort = args[2];
        port = Integer.parseInt(serverPort);
        try {
            this.parseInputArguments(args);
        } catch (Exception e) {
            throw new IllegalArgumentException("ERROR\tIncorrect input syntax: Please check arguments and try again");
        }
        if (server == null || name == null) {
            throw new IllegalArgumentException("ERROR\tIncorrect input syntax: Server IP and domain name must be provided.");
        }
    }

    public void makeRequest(String retryNo) {
        maxRetries=Integer.parseInt(retryNo);
       // System.out.println("DnsClient sending request for " + name);
       // System.out.println("Server: " + address);
       // System.out.println("Request type: " + queryType);
        pollRequest(1);
    }

    private void pollRequest(int retryNumber) {
        if (retryNumber > maxRetries) {
            System.out.println("ERROR\tMaximum number of retries " + maxRetries + " exceeded");
            return;
        }

        try {
            //Create Datagram socket and request object(s)
            DatagramSocket socket = new DatagramSocket();
            socket.setSoTimeout(timeout);
            InetAddress inetaddress = InetAddress.getByAddress(server);
            DnsRequest request = new DnsRequest(name, queryType);

            byte[] requestBytes = request.getRequest();
            byte[] responseBytes = new byte[1024];

            DatagramPacket requestPacket = new DatagramPacket(requestBytes, requestBytes.length, inetaddress, port);
            DatagramPacket responsePacket = new DatagramPacket(responseBytes, responseBytes.length);

            //Send packet and time response
            long startTime = System.currentTimeMillis();
            socket.send(requestPacket);
            socket.receive(responsePacket);
            long endTime = System.currentTimeMillis();
            socket.close();
            responseTime = (endTime - startTime) / 1000. + "";
            retries = (retryNumber - 1) + "";
            //System.out.println("Response received after " + (endTime - startTime) / 1000. + " seconds " + "(" + (retries) + " retries)");
            DnsResponse response = new DnsResponse(responsePacket.getData(), requestBytes.length, queryType);
            response.outputResponse();


        } catch (SocketException e) {
            System.out.println("ERROR\tCould not create socket");
        } catch (UnknownHostException e) {
            DnsClient.status = "Unknown host";
            System.out.println("ERROR\tUnknown host");
        } catch (SocketTimeoutException e) {
            DnsClient.status = "Timeout";
            System.out.println("ERROR\tSocket Timeout");
            System.out.println("Reattempting request...");
            pollRequest(++retryNumber);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

    public String getResponseTime() {
        return responseTime;
    }

    public String getTimeToLive() {
        return timeToLive;
    }

    public String getRetries() {
        return retries;
    }

    public String getDomainName_IP() {
        return domainName_IP;
    }

    private void parseInputArguments(String args[]) {
        List<String> argsList = Arrays.asList(args);
        ListIterator<String> iterator = argsList.listIterator();

        while (iterator.hasNext()) {
            String arg = iterator.next();
            switch (arg) {
                case "-t":
                    timeout = Integer.parseInt(iterator.next()) * 1000;
                    break;
                case "-r":
                    maxRetries = Integer.parseInt(iterator.next());
                    break;
                case "-p":
                    port = Integer.parseInt(iterator.next());
                    break;
                case "-mx":
                    queryType = QueryType.MX;
                    break;
                case "-ns":
                    queryType = QueryType.NS;
                    break;
                default:
                    if (arg.contains("@")) {
                        address = arg.substring(1);
                        String[] addressComponents = address.split("\\.");

                        for (int i = 0; i < addressComponents.length; i++) {
                            int ipValue = Integer.parseInt(addressComponents[i]);
                            if (ipValue < 0 || ipValue > 255) {
                                throw new NumberFormatException("ERROR\tIncorrect input syntax: IP Address numbers must be between 0 and 255, inclusive.");
                            }
                            server[i] = (byte) ipValue;
                        }
                        name = iterator.next();
                    }
                    break;
            }
        }
    }

}
