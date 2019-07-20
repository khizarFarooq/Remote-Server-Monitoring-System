package structures;

public class DnsPacket {
    String responseTime;
    String retries;
    String domainName_IP;
    String hostIp;
    String status;
    String timeStamp;
    String TTL;

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
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


    public String getResponseTime() {
        return responseTime;
    }

    public void setResponseTime(String responseTime) {

        this.responseTime = responseTime;

    }

    public String getRetries() {
        return retries;
    }

    public void setRetries(String retries) {
        this.retries = retries;
    }

    public String getDomainName_IP() {
        return domainName_IP;
    }

    public void setDomainName_IP(String domainName_IP) {
        this.domainName_IP = domainName_IP;
    }

    public String getTTL() {
        return TTL;
    }

    public void setTTL(String TTL) {
        this.TTL = TTL;
    }
}
