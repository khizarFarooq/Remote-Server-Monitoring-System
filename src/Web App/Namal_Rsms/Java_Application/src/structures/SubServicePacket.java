package structures;

public class SubServicePacket {
    SubServicesTypes type;
    Object packet;

    public SubServicesTypes getType() {
        return type;
    }

    public void setType(SubServicesTypes type) {
        this.type = type;
    }

    public Object getPacket() {
        return packet;
    }

    public void setPacket(Object packet) {
        this.packet = packet;
    }
}
