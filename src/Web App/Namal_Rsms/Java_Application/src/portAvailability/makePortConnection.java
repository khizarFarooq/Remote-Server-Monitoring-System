package portAvailability;

import java.io.IOException;
import java.net.Socket;
import java.net.UnknownHostException;

public class makePortConnection {
    public static String status;
    String host, maxRetries;
    int port;

    public makePortConnection(String host, int port) {
        this.host = host;
        this.port = port;
    }

    public void makeRequest(String maxRetries) {
        this.maxRetries = maxRetries;
        pollRequest(1);
    }

    public void pollRequest(int retryNo) {
        if (retryNo > Integer.parseInt(maxRetries)) {
            System.out.println("ERROR\tMaximum number of retries " + maxRetries + " exceeded");
            return;
        }
        Socket socket;
        try {
            socket = new Socket(host, port);
            if (socket.isConnected()) {
                makePortConnection.status = "up";

            }
        } catch (UnknownHostException e) {
            makePortConnection.status = "Unknown Host";
            System.out.println("Reattempting request...");
            pollRequest(++retryNo);

        } catch (IOException e) {
            makePortConnection.status = "Time Out";
            System.out.println("Reattempting request...");
            pollRequest(++retryNo);

        }
    }
}
