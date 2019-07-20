package webServerClient;

import structures.HttpsPacket;

import java.text.SimpleDateFormat;
import java.util.Date;

public class WebServerClient {
    private final String USER_AGENT = "Mozilla/5.0";
    public String hostIp;
    public HttpsPacket httpsPacket;

    // HTTP GET request
    public HttpsPacket send_Get_Request(String url, String maxRetries) throws Exception {
        SimpleDateFormat formatter = new SimpleDateFormat("dd/MM/yyyy hh:mm:ss");
        Date date = new Date();
        String Date = formatter.format(date);
        httpsPacket = new HttpsPacket();
        httpsRequestResonse httpsRequestResonse = new httpsRequestResonse(url);
        httpsRequestResonse.makeRequest(maxRetries);
        if (httpsRequestResonse.responseStatusCode == 200) {
            httpsPacket.setType(HttpsPacket.packetType.UP);
            httpsPacket.setHostIp(url);
            httpsPacket.setStatusResponseCode(httpsRequestResonse.responseStatusCode);
            httpsPacket.setTimeStamp(Date);
        }
        if (httpsRequestResonse.responseStatusCode == 503) {
            httpsPacket.setType(HttpsPacket.packetType.DOWN);
            httpsPacket.setStatusResponseCode(httpsRequestResonse.responseStatusCode);
            httpsPacket.setTimeStamp(Date);
        }
        return httpsPacket;
    }

    public static void main(String[] args) {
    }
}