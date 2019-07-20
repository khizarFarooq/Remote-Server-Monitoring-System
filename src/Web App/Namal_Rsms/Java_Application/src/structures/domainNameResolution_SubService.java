package structures;
import dnsClient.dnsApp;
public class domainNameResolution_SubService extends SubService {
    private String[] serverName_domainName;
    private long delay;
    DnsPacket dnsPacket;

    public domainNameResolution_SubService(String[] serverName_domainName, String normalCheckingMinutes) {
        this.serverName_domainName = serverName_domainName;
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(normalCheckingMinutes));
    }

    public void setRecheckDelay(String recheckMinutes) {
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(recheckMinutes));
    }

    public domainNameResolution_SubService() {

    }

    @Override
    public void run() {

        while (runService) {
            dnsApp dnsDnsApp = new dnsApp();
            dnsPacket = dnsDnsApp.checkDNS(serverName_domainName);
            this.type = SubServicesTypes.DNS_TESTING;
            publishProgress(dnsPacket);
            try {
                sleep(delay);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            System.out.println("Dns query sub-service running of this host : " + dnsPacket.getHostIp());
        }
        System.err.println("Dns query sub-service stopped of this host : " + dnsPacket.getHostIp());

    }
}
