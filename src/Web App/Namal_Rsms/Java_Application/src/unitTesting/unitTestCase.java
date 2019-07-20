package unitTesting;

import dnsClient.dnsApp;
import hostAvailability.Ping;
import org.junit.Before;
import org.junit.Test;
import portAvailability.PortAvailability;
import proxyServerClient.ProxyClient;
import structures.DnsPacket;
import structures.HttpsPacket;
import structures.PingPacket;
import structures.ServerAvailabilityPacket;
import webServerClient.WebServerClient;

import static org.junit.Assert.assertEquals;

public class unitTestCase {
    PingPacket pingPacket;
    Ping ping;
    ServerAvailabilityPacket serverAvailabilityPacket;
    PortAvailability portAvailability;
    WebServerClient webServerClient;
    HttpsPacket webHttpsPacket;
    ProxyClient proxyClient;
    dnsApp dnsClient;
    DnsPacket dnsPacket;

    @Before
    public void setUp() {
        ping = new Ping();
        pingPacket = ping.pingHost("10.0.0.157", "3");
        portAvailability = new PortAvailability();
        serverAvailabilityPacket = portAvailability.serverListeningOnPort("10.0.0.159", 80, "3");
        webServerClient = new WebServerClient();
        proxyClient = new ProxyClient();
        dnsClient = new dnsApp();
        dnsPacket = new DnsPacket();
        String[] dnsInfo = {"@172.16.0.1", "www.namal.edu.pk", "53", "3"};
        try {
            webHttpsPacket = webServerClient.send_Get_Request("10.0.0.157", "3");
        } catch (Exception e) {
            e.printStackTrace();
        }
        dnsPacket = dnsClient.checkDNS(dnsInfo);
    }

    @Test
    public void test_PingHostMethod() {
        assertEquals("Output:", "OK", pingPacket.getType().toString());
    }

    @Test
    public void test_serverListeningOnPortMethod() {
        assertEquals("Output:", "up", serverAvailabilityPacket.isAvailability());
    }

    @Test
    public void test_webClient_httpsGetRequestMethod() {
        assertEquals("Output:", "UP", webHttpsPacket.getType().toString());
    }

    @Test
    public void test_checkDnsMethod() {
        assertEquals("Output:", "OK", dnsPacket.getStatus());
    }
}