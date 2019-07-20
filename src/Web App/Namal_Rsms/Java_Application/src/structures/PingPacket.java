package structures;

public class PingPacket {


    public enum PacketTYPE {
        OK, UNREACHABLE, TIMEOUT
    }

    public PacketTYPE getType() {
        return type;
    }

    public void setType(PacketTYPE type) {
        this.type = type;
    }

    private String error;
    private String serverName;
    private String TTL;
    private String noOfSentPackets;
    private String noOfReceivedPackets;
    private String noOfLostPackets;
    private String maxRTT;
    private String minRTT;
    private String avgRTT;
    private String hostIp;

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
    private PacketTYPE type;

    public String getServerName() {
        return serverName;
    }

    public String getError() {
        return error;
    }

    public void setError(String error) {
        this.error = error;
    }

    public void setServerName(String serverName) {
        this.serverName = serverName;
    }

    public String getTTL() {
        return TTL;
    }

    public void setTTL(String TTL) {
        this.TTL = TTL;
    }

    public String getNoOfSentPackets() {
        return noOfSentPackets;
    }

    public void setNoOfSentPackets(String noOfSentPackets) {
        this.noOfSentPackets = noOfSentPackets;
    }

    public String getNoOfReceivedPackets() {
        return noOfReceivedPackets;
    }

    public void setNoOfReceivedPackets(String noOfReceivedPackets) {
        this.noOfReceivedPackets = noOfReceivedPackets;
    }

    public String getNoOfLostPackets() {
        return noOfLostPackets;
    }

    public void setNoOfLostPackets(String noOfLostPackets) {
        this.noOfLostPackets = noOfLostPackets;
    }

    public String getMaxRTT() {
        return maxRTT;
    }

    public void setMaxRTT(String maxRTT) {
        this.maxRTT = maxRTT;
    }

    public String getMinRTT() {
        return minRTT;
    }

    public void setMinRTT(String minRTT) {
        this.minRTT = minRTT;
    }

    public String getAvgRTT() {
        return avgRTT;
    }

    public void setAvgRTT(String avgRTT) {
        this.avgRTT = avgRTT;
    }
}
