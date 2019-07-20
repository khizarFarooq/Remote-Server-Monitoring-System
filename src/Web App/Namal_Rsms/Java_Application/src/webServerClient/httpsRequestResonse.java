package webServerClient;

import java.net.HttpURLConnection;
import java.net.URL;

public class httpsRequestResonse {
    String url, maxRetries;
    private final String USER_AGENT = "Mozilla/5.0";
    public static int responseStatusCode;
    HttpURLConnection con;

    public httpsRequestResonse(String url) {
        if(url.matches("^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$")) {
            this.url = "http://" + url;
        }
        else
            this.url=url;
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
        try {
            con = (HttpURLConnection) new URL(url).openConnection();
            //System.out.println("Connection established");
            // optional default is GET
            con.setRequestMethod("GET");
            // TimeOut 5 second
            con.setConnectTimeout(5000);
            // add request header
            con.setRequestProperty("User-Agent", USER_AGENT);
            // System.out.println("\nSending 'GET' request to URL : " + Url);
            responseStatusCode = con.getResponseCode();
            if (responseStatusCode == 503) {
                System.out.println("Reattempting request...");
                pollRequest(++retryNo);
            }
        } catch (Exception e) {
            System.out.println(e);
            pollRequest(++retryNo);
        }
    }
}
