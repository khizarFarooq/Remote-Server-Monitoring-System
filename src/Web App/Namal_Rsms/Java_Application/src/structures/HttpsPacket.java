package structures;

public class HttpsPacket {
    public enum packetType {
        UP, DOWN
    }

    private int StatusResponseCode;
    private String hostIp;
    private packetType type;

    public packetType getType() {
        return type;
    }

    public void setType(packetType type) {
        this.type = type;
    }

    public String getHostIp() {
        return hostIp;
    }

    public void setHostIp(String hostIp) {
        this.hostIp = hostIp;
    }

    public String getTimeStamp() {
        return timeStamp;
    }

    public void setTimeStamp(String timeStamp) {
        this.timeStamp = timeStamp;
    }

    private String timeStamp;

    public int getStatusResponseCode() {
        return StatusResponseCode;
    }

    public void setStatusResponseCode(int statusResponseCode) {
        StatusResponseCode = statusResponseCode;
    }
}
