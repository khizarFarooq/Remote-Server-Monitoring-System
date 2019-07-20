package portAvailability;

import structures.ServerAvailabilityPacket;

import java.io.IOException;
import java.net.Socket;
import java.net.UnknownHostException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class PortAvailability {
    public ServerAvailabilityPacket serverListeningOnPort(String host, int port, String maxRetries) {

        ServerAvailabilityPacket serverAvailabilityPacket = new ServerAvailabilityPacket();
        SimpleDateFormat formatter = new SimpleDateFormat("dd/MM/yyyy hh:mm:ss");
        Date date = new Date();
        String Date = formatter.format(date);
        try {
            makePortConnection makePortConnection = new makePortConnection(host, port);
            makePortConnection.makeRequest(maxRetries);
            serverAvailabilityPacket.setAvailability(makePortConnection.status);
            serverAvailabilityPacket.setTimeStamp(Date);
            serverAvailabilityPacket.setHostIp(host);
            serverAvailabilityPacket.setServerPort(port);
            return serverAvailabilityPacket;

        } catch (Exception e) {
            System.out.println(e);
        }
        return serverAvailabilityPacket;
    }

    public static void main(String[] args) {

    }

}
