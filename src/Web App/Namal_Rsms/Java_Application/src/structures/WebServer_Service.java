package structures;

public class WebServer_Service extends Service {
    @Override
    public void run() {

        prepareServices();
        for (SubService ss : subServices) {
            ss.startService();
        }
    }

    @Override
    public void prepareServices() {

        for (SubService ss : subServices) {
            ss.addListener(new SubService.SubServiceListener() {
                @Override
                public void getResult(SubServicePacket packet) {
                    ServicePacket servicePacket = new ServicePacket();
                    servicePacket.setSubServiceType(packet.getType());
                    servicePacket.setSubServicePacket(packet.getPacket());
                    servicePacket.setType(ServerTypes.WEB_SERVER);
                    System.out.println("Response received from: " + packet.getType() + " In " + servicePacket.getType());
                    publishProgress(servicePacket);
                }
            });
        }
    }
}
