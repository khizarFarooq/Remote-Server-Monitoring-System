package dnsClient;

import structures.DnsPacket;
import java.text.SimpleDateFormat;
import java.util.Date;

public class dnsApp {
    String responseTime, retries, hostIp, retryNo;
    DnsPacket dnsPacket = new DnsPacket();

    public DnsPacket checkDNS(String[] serverName_domainName) {
        hostIp = serverName_domainName[0];
        retryNo = serverName_domainName[3];
        hostIp = hostIp.replace("@", "");
        SimpleDateFormat formatter = new SimpleDateFormat("dd/MM/yyyy hh:mm:ss");
        Date date = new Date();
        String Date = formatter.format(date);
        try {

            DnsClient client = new DnsClient(serverName_domainName);
            client.makeRequest(retryNo);
            responseTime = client.getResponseTime();
            dnsPacket.setResponseTime(responseTime);
            retries = client.getRetries();
            dnsPacket.setRetries(retries);
            dnsPacket.setDomainName_IP(DnsClient.domainName_IP);
            dnsPacket.setTTL(DnsClient.timeToLive);
            dnsPacket.setTimeStamp(Date);
            dnsPacket.setHostIp(hostIp);
            dnsPacket.setStatus(DnsClient.status);
            dnsPacket.setTimeStamp(Date);
            return dnsPacket;
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
        return dnsPacket;

    }

    public static void main(String args[]) throws Exception {
    }
}


