package structures;

import webServerClient.WebServerClient;

public class WebServer_TestingSubService extends SubService {
    private String url, retryNo;
    private long delay;
    HttpsPacket httpsPacket;

    public WebServer_TestingSubService(String url, String normalCheckingMinutes, String retryNo) {
        this.url = url;
        this.retryNo = retryNo;
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(normalCheckingMinutes));
    }

    public void setRecheckDelay(String recheckMinutes) {
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(recheckMinutes));
    }

    public WebServer_TestingSubService() {

    }

    @Override
    public void run() {
        while (runService) {
            WebServerClient https_request = new WebServerClient();
            try {
                httpsPacket = https_request.send_Get_Request(url, retryNo);
                this.type = SubServicesTypes.WEB_SERVER_TESTING;
                publishProgress(httpsPacket);
                sleep(delay);
            } catch (Exception e) {
                e.printStackTrace();
            }
            System.out.println("WebServer testing sub-service running of this host : " + httpsPacket.getHostIp());
        }
        System.err.println("WebServer testing sub-service stopped of this host : " + httpsPacket.getHostIp());

    }
}
