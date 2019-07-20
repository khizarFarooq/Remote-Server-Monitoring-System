package structures;
import java.util.ArrayList;
public abstract class SubService extends Thread {
    public boolean runService = true;
    public static SubServicesTypes type;
    private ArrayList<SubServiceListener> listeners = new ArrayList<>();

    public SubService(SubServicesTypes type) {
        this.type = type;
    }

    public SubService() {

    }

    public void addListener(SubServiceListener listener) {
        listeners.add(listener);
    }

    public void removeListener(SubServiceListener listener) {
        listeners.remove(listener);
    }

    public void stopService() {
        runService = false;
        System.out.println("Stop service flag is set ....");
        System.out.println("Stop Flag value is : " + runService);
    }

    public void startService() {
        runService = true;
        start();
    }

    @Override
    public abstract void run();

    public interface SubServiceListener {
        public void getResult(SubServicePacket packet);
    }

    public void publishProgress(Object packet) {
        for (SubServiceListener listener : listeners) {
            if (listener != null) {
                SubServicePacket p = new SubServicePacket();
                p.setType(type);
                p.setPacket(packet);
                listener.getResult(p);
            } else
                listeners.remove(listener);
        }
    }
}