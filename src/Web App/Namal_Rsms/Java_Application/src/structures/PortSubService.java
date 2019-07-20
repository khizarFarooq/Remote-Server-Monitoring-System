package structures;

import portAvailability.PortAvailability;

public class PortSubService extends SubService {
    ServerAvailabilityPacket serverAvailabilityPacket;
    private String host, retryNo;
    private int port;
    private long delay;

    public PortSubService(String host, int port, String normalCheckingMinutes, String retryNo) {
        this.host = host;
        this.port = port;
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(normalCheckingMinutes));
        this.retryNo = retryNo;
    }

    public PortSubService() {

    }

    public void setRecheckDelay(String recheckMinutes) {
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(recheckMinutes));
    }

    @Override
    public void run() {
        while (runService) {
            PortAvailability portAvailability = new PortAvailability();
            serverAvailabilityPacket = portAvailability.serverListeningOnPort(host, port, retryNo);
            this.type = SubServicesTypes.SERVER_AVAILABILITY;
            publishProgress(serverAvailabilityPacket);
            try {
                sleep(delay);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            System.out.println("Server port availability sub-service running of this host : " + serverAvailabilityPacket.getHostIp());
        }
        System.err.println("Server port availability sub-service stopped of this host : " + serverAvailabilityPacket.getHostIp());
    }

}
