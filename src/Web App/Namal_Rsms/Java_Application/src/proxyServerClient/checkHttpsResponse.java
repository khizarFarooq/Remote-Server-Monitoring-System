package proxyServerClient;

import java.net.HttpURLConnection;
import java.net.InetSocketAddress;
import java.net.Proxy;
import java.net.URL;

public class checkHttpsResponse {
    private final String USER_AGENT = "Mozilla/5.0";
    public static int responseStatusCode;
    private Proxy proxy;
    private String maxRetries, hostName, url;
    int portNumber;

    public checkHttpsResponse(String hostName, int portNumber, String url) {
        this.hostName = hostName;
        this.portNumber = portNumber;
        this.url = url;
    }

    public void makeRequest(String maxRetries) {
        this.maxRetries = maxRetries;
        try {
            pollRequest(1);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void pollRequest(int retryNo) {
        if (retryNo > Integer.parseInt(maxRetries)) {
            System.out.println("ERROR\tMaximum number of retries " + maxRetries + " exceeded");
            return;
        }
        this.proxy = new Proxy(Proxy.Type.HTTP, new InetSocketAddress(hostName, portNumber));
        try {
            URL Url = new URL("https://" + url);
            System.out.println("Establishing connection with proxy server " + hostName);
            HttpURLConnection con = (HttpURLConnection) Url.openConnection(proxy);
            // optional default is GET
            con.setRequestMethod("GET");
            // TimeOut 5 second
            con.setConnectTimeout(5000);
            // add request header
            con.setRequestProperty("User-Agent", USER_AGENT);
            System.out.println("\nSending 'GET' request to URL : " + url);
            responseStatusCode = con.getResponseCode();
            if (responseStatusCode == 504) {
                System.out.println("Reattempting request...");
                pollRequest(++retryNo);
            }
        } catch (Exception e) {
            System.out.println(e);
            pollRequest(++retryNo);
        }

    }
}

