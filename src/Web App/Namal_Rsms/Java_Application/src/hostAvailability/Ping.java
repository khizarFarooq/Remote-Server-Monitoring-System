package hostAvailability;

import java.util.Date;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.text.SimpleDateFormat;

import structures.PingPacket;

public class Ping {
    public String pingResponse = "";
    String hostIp, TTL, data, error, replyFrom, roundTripTime, responseServer,
            packetStatistics, Sent, Received, Lost, RttMin, RttMax, RttAve, maxRetries;
    public String[] splitpingResponse;
    String[] packetStatisticsSplit, responseServerSplit, TTLSplit;

    // Method to run Ping command and return response against it.
    public String runCommand(String command) {
        try {
            Process p = Runtime.getRuntime().exec(command);
            BufferedReader inputStream = new BufferedReader(
                    new InputStreamReader(p.getInputStream()));
            // Reading output stream of the command
            while ((data = inputStream.readLine()) != null) {
                pingResponse = pingResponse.concat(data) + "\n";
                // System.out.println(data);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return pingResponse;
    }

    // Method to split Ping response
    public PingPacket splitPingResponse(String pingResponse, int retryNo) {
        // Spiting Ping response into array
        PingPacket pingPacket = new PingPacket();
        SimpleDateFormat formatter = new SimpleDateFormat("dd/MM/yyyy hh:mm:ss");
        Date date = new Date();
        String Date = formatter.format(date);

        splitpingResponse = pingResponse.split(":");
        // System.out.println(splitpingResult.length);
        if (splitpingResponse.length == 4) {
            error = splitpingResponse[1];
            pingPacket.setError(splitpingResponse[1]);
            String[] errorSplit = error.split(".\n");
            error = errorSplit[0];
            packetStatistics = splitpingResponse[3];
            packetStatisticsSplit = packetStatistics.split(",");
            Sent = packetStatisticsSplit[0];
            Received = packetStatisticsSplit[1];
            Lost = packetStatisticsSplit[2];
            packetStatisticsSplit = Sent.split("=");
            Sent = packetStatisticsSplit[1];
            packetStatisticsSplit = Received.split("=");
            Received = packetStatisticsSplit[1];
            packetStatisticsSplit = Lost.split("=");
            Lost = packetStatisticsSplit[1];
            packetStatisticsSplit = Lost.split(" ");
            Lost = packetStatisticsSplit[1];
            splitpingResponse[0] = error;
            splitpingResponse[1] = Sent;
            splitpingResponse[2] = Received;
            splitpingResponse[3] = Lost;
            pingPacket.setHostIp(hostIp);
            pingPacket.setError(error);
            pingPacket.setNoOfLostPackets(Lost);
            pingPacket.setNoOfReceivedPackets(Received);
            pingPacket.setNoOfSentPackets(Sent);
            pingPacket.setType(PingPacket.PacketTYPE.TIMEOUT);
            pingPacket.setTimeStamp(Date);


        } else if (splitpingResponse.length == 8) {
            responseServer = splitpingResponse[2];
            responseServerSplit = responseServer.split(".\n");
            replyFrom = responseServerSplit[1];
            error = responseServerSplit[0];
            responseServerSplit = replyFrom.split(" ");
            replyFrom = responseServerSplit[2];
            packetStatistics = splitpingResponse[7];
            packetStatisticsSplit = packetStatistics.split(",");
            Sent = packetStatisticsSplit[0];
            Received = packetStatisticsSplit[1];
            Lost = packetStatisticsSplit[2];
            packetStatisticsSplit = Sent.split("=");
            Sent = packetStatisticsSplit[1];
            packetStatisticsSplit = Received.split("=");
            Received = packetStatisticsSplit[1];
            packetStatisticsSplit = Lost.split("=");
            Lost = packetStatisticsSplit[1];
            packetStatisticsSplit = Lost.split(" ");
            Lost = packetStatisticsSplit[1];
            splitpingResponse[0] = replyFrom;
            splitpingResponse[1] = error;
            splitpingResponse[2] = Sent;
            splitpingResponse[3] = Received;
            splitpingResponse[4] = Lost;
            for (int i = 5; i < splitpingResponse.length; i++) {
                splitpingResponse[i] = "";
            }
            pingPacket.setHostIp(hostIp);
            pingPacket.setServerName(replyFrom);
            pingPacket.setError(error);
            pingPacket.setNoOfSentPackets(Sent);
            pingPacket.setNoOfReceivedPackets(Received);
            pingPacket.setNoOfLostPackets(Lost);
            pingPacket.setType(PingPacket.PacketTYPE.UNREACHABLE);
            pingPacket.setTimeStamp(Date);
        } else if (splitpingResponse.length == 9) {
            responseServer = splitpingResponse[2];
            packetStatistics = splitpingResponse[7];
            roundTripTime = splitpingResponse[8];
            responseServerSplit = responseServer.split(" ");
            TTL = responseServerSplit[2];
            TTLSplit = TTL.split("=");
            TTL = TTLSplit[1];
            replyFrom = responseServerSplit[5];
            String[] roundTripTimeSplit = roundTripTime.split(",");
            RttMin = roundTripTimeSplit[0];
            RttMax = roundTripTimeSplit[1];
            RttAve = roundTripTimeSplit[2];
            roundTripTimeSplit = RttMin.split("=");
            RttMin = roundTripTimeSplit[1];
            roundTripTimeSplit = RttMax.split("=");
            RttMax = roundTripTimeSplit[1];
            roundTripTimeSplit = RttAve.split("=");
            RttAve = roundTripTimeSplit[1];
            packetStatisticsSplit = packetStatistics.split(",");
            Sent = packetStatisticsSplit[0];
            Received = packetStatisticsSplit[1];
            Lost = packetStatisticsSplit[2];
            packetStatisticsSplit = Sent.split("=");
            Sent = packetStatisticsSplit[1];
            packetStatisticsSplit = Received.split("=");
            Received = packetStatisticsSplit[1];
            packetStatisticsSplit = Lost.split("=");
            Lost = packetStatisticsSplit[1];
            packetStatisticsSplit = Lost.split(" ");
            Lost = packetStatisticsSplit[1];
            splitpingResponse[0] = replyFrom;
            splitpingResponse[1] = TTL;
            splitpingResponse[2] = Sent;
            splitpingResponse[3] = Received;
            splitpingResponse[4] = Lost;
            splitpingResponse[5] = RttMin;
            splitpingResponse[6] = RttMax;
            splitpingResponse[7] = RttAve;
            pingPacket.setHostIp(hostIp);
            pingPacket.setTTL(TTL);
            pingPacket.setAvgRTT(RttAve);
            pingPacket.setMaxRTT(RttMax);
            pingPacket.setMinRTT(RttMin);
            pingPacket.setNoOfLostPackets(Lost);
            pingPacket.setType(PingPacket.PacketTYPE.OK);
            pingPacket.setNoOfReceivedPackets(Received);
            pingPacket.setNoOfSentPackets(Sent);
            pingPacket.setServerName(replyFrom);
            pingPacket.setTimeStamp(Date);
        }

        return pingPacket;
    }

    public PingPacket pingHost(String host, String maxRetries) {
        hostIp = host;
        this.maxRetries = maxRetries;
        pingResponse = runCommand("Ping " + host);
        // call to Method splitPingResponse which split response of that Ping.
        return splitPingResponse(pingResponse, 1);
    }

    public static void main(String[] args) {
    }
}