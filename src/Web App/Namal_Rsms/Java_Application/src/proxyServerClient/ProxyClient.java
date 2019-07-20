package proxyServerClient;

import structures.HttpsPacket;

import java.text.SimpleDateFormat;
import java.util.Date;

import static structures.HttpsPacket.packetType.DOWN;
import static structures.HttpsPacket.packetType.UP;

public class ProxyClient {
    public HttpsPacket httpsPacket;

    // HTTP GET request
    public HttpsPacket send_Get_Request(String hostIp, int portNumber, String url, String maxRetries) {
        SimpleDateFormat formatter = new SimpleDateFormat("dd/MM/yyyy hh:mm:ss");
        Date date = new Date();
        String Date = formatter.format(date);
        httpsPacket = new HttpsPacket();
        checkHttpsResponse checkHttpsResponse = new checkHttpsResponse(hostIp, portNumber, url);
        checkHttpsResponse.makeRequest(maxRetries);

        if (checkHttpsResponse.responseStatusCode == 200 || checkHttpsResponse.responseStatusCode == 403) {
            httpsPacket.setType(UP);
            httpsPacket.setHostIp(hostIp);
            httpsPacket.setStatusResponseCode(checkHttpsResponse.responseStatusCode);
            httpsPacket.setTimeStamp(Date);
        }
        if (checkHttpsResponse.responseStatusCode == 504) {
            httpsPacket.setHostIp(hostIp);
            httpsPacket.setStatusResponseCode(checkHttpsResponse.responseStatusCode);
            httpsPacket.setType(DOWN);
            httpsPacket.setTimeStamp(Date);
        }

        return httpsPacket;

    }

    public static void main(String[] args) {
    }
}
