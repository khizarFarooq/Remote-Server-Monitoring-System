package structures;
import hostAvailability.Ping;
public class PingSubService extends SubService {

    PingPacket packet;
    private String host, retryNo;
    private long delay;

    public PingSubService(String host, String normalCheckingMinutes, String retryNo) {

        this.host = host;
        this.retryNo = retryNo;
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(normalCheckingMinutes));
    }

    public PingSubService() {

    }

    public void setRecheckDelay(String recheckMinutes) {
        delay = java.util.concurrent.TimeUnit.MINUTES.toMillis(Long.parseLong(recheckMinutes));
    }

    @Override
    public void run() {

        while (runService) {
            Ping p = new Ping();
            packet = p.pingHost(host, retryNo);
            this.type = SubServicesTypes.HOST_AVAILABILITY;
            publishProgress(packet);
            try {
                sleep(delay);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
            System.out.println("Ping sub-service running of this host : " + packet.getHostIp());
        }
        System.err.println("Ping sub-service stopped of this host : " + packet.getHostIp());
    }
}
