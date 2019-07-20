package structures;

import proxyServerClient.ProxyClient;

public class ProxyServer_TestingSubService extends SubService {
    private String proxyServerIp, url, retryNo;
    private int portNumber;
    private long delay;
    HttpsPacket httpsPacket;

    public ProxyServer_TestingSubService(String proxyServerIp, int portNumber, String url, String normalCheckingMinutes, String retryNo) {
        this.proxyServerIp = proxyServerIp;
        this.portNumber = portNumber;
        this.url = url;
        this.retryNo = retryNo;
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(normalCheckingMinutes));
    }

    public void setRecheckDelay(String recheckMinutes) {
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(recheckMinutes));
    }

    public ProxyServer_TestingSubService() {

    }

    @Override
    public void run() {
        while (runService) {
            ProxyClient proxyClient = new ProxyClient();
            try {
                httpsPacket = proxyClient.send_Get_Request(proxyServerIp, portNumber, url, retryNo);
                this.type = SubServicesTypes.PROXY_SERVER_TESTING;
                publishProgress(httpsPacket);
                sleep(delay);
            } catch (Exception e) {
                System.out.println("Exception : " + e);
            }
            System.out.println("ProxyServer testing sub-service running of this host : " + httpsPacket.getHostIp());
        }
        System.err.println("ProxyServer testing sub-service stopped of this host : " + httpsPacket.getHostIp());
    }
}
