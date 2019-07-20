package structures;

import java.util.ArrayList;

public abstract class Service {
    public boolean startService = true;
    private ArrayList<ProgressListener> listeners = new ArrayList<>();

    public ArrayList<SubService> subServices = new ArrayList<>();

    public void addSubService(SubService service) {
        subServices.add(service);
        System.out.println("Sub-Service has been added ....");
    }

    public SubService getSubService(SubServicesTypes type) {
        for (SubService service : subServices) {
            System.out.println("SS type: " + service.type + "\tReceived Type: " + type);
            if (service.type.equals(type))
                return service;
        }
        return null;
    }

    public void removeSubService(SubService service) {
        subServices.remove(service);
    }


    public void startService() {
        startService = true;
        run();
        System.out.println("Service has been started ....");
    }

    public void stopService() {
        startService = false;
        System.out.println("Service has been stopped ....");
        for (SubService service : subServices
                ) {
            service.stopService();
        }
    }

    public void addListener(ProgressListener listener) {
        listeners.add(listener);

    }

    public abstract void run();

    public abstract void prepareServices();


    public void removeListener(ProgressListener listener) {
        listeners.remove(listener);
    }

    public void publishProgress(ServicePacket packet) {
        for (ProgressListener p : listeners) {
            if (p != null) {
                p.getProgress(packet);
            } else {
                listeners.remove(p);
            }
        }
    }

    public interface ProgressListener {
        public void getProgress(ServicePacket packet);
    }


}
