package structures;

public class DnsService extends Service {
    public DnsService() {
    }

    public void prepareServices() {

        for (SubService ss : subServices) {
            ss.addListener(new SubService.SubServiceListener() {
                @Override
                public void getResult(SubServicePacket packet) {
                    ServicePacket p = new ServicePacket();
                    p.setSubServiceType(packet.getType());
                    p.setSubServicePacket(packet.getPacket());
                    p.setType(ServerTypes.DNS);
                    System.out.println("Response Received from: " + packet.getType() + " In " + p.getType());
                    publishProgress(p);
                }
            });
        }

    }

    @Override
    public void run() {
        prepareServices();
        for (SubService ss : subServices) {
            ss.startService();
        }
    }
}
