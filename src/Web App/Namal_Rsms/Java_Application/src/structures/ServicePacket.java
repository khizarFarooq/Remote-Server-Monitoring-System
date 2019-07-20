package structures;

public class ServicePacket {
    private ServerTypes type;
    private SubServicesTypes subServiceType;
    private Object subServicePacket;

    public SubServicesTypes getSubServiceType() {
        return subServiceType;
    }

    public void setSubServiceType(SubServicesTypes subServiceType) {
        this.subServiceType = subServiceType;
    }

    public Object getSubServicePacket() {
        return subServicePacket;
    }

    public void setSubServicePacket(Object subServicePacket) {
        this.subServicePacket = subServicePacket;
    }

    public ServerTypes getType() {
        return type;
    }

    public void setType(ServerTypes type) {
        this.type = type;
    }

}
