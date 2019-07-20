package alertAgent;

import structures.ServerTypes;
import structures.SubServicesTypes;
import java.sql.*;
import java.util.*;
import java.util.Date;
import javax.mail.*;
import javax.mail.internet.*;
import javax.mail.internet.MimeMessage;

public class emailAlert {
    String subject, messageText, serverName, emailAddress;
    String[] adminEmailAddresses = new String[100];
    String[] webAccessLocalUserEmailAddresses = new String[100];
    String[] proxyAccessLocalUserEmailAddresses = new String[100];
    String[] DnsAccessLocalUserEmailAddresses = new String[100];
    int serverPort, adminCounter = 0, localProxyCounter = 0, localWebCounter = 0, localDNSCounter = 0;

    public void sendEmailAlert(String Host, int port, ServerTypes serverType, SubServicesTypes service, String issue, String timeStamp) {
        try {
            // create our mysql database connection
            String myDriver = "com.mysql.jdbc.Driver";
            //here namal_rsms is database name, root is username and password is nothing.
            String myUrl = "jdbc:mysql://localhost:3306/namal_rsms";
            Class.forName(myDriver);
            String userName = "root", password = "";
            Connection con = DriverManager.getConnection(myUrl, userName, password);
            // create the java statement
            Statement stmt = con.createStatement();
            // our SQL SELECT query.
            String adminSelectQuery = "SELECT * FROM `user_accounts_info` WHERE Authorization_level='admin';";
            // execute the query, and get a java resultset
            ResultSet output = stmt.executeQuery(adminSelectQuery);
            while (output.next()) {
                emailAddress = output.getString("Email");
                adminEmailAddresses[adminCounter] = emailAddress;
                adminCounter++;
            }
            if (serverType.equals(ServerTypes.PROXY_SERVER)) {
                String selectQuery = "SELECT * FROM `proxy_server_info` WHERE Host_ip=INET_ATON('" + Host + "')";
//                // execute the query, and get a java resultset
                ResultSet result = stmt.executeQuery(selectQuery);
                while (result.next()) {
                    serverName = result.getString("Server_name");
                    serverPort = result.getInt("Server_port");
                }
                selectQuery = "SELECT * FROM `user_accounts_info` WHERE Authorization_level='local' AND  proxyServer_Access='yes';";
                // execute the query, and get a java resultset
                result = stmt.executeQuery(selectQuery);
                while (result.next()) {
                    emailAddress = result.getString("Email");
                    proxyAccessLocalUserEmailAddresses[localProxyCounter] = emailAddress;
                    localProxyCounter++;
                }

                if (service.equals(SubServicesTypes.HOST_AVAILABILITY)) {
                    subject = "Proxy Server Host is not accessible";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that" + "\n\t" + serverName + " host " + Host + " was reported inaccessible at " + timeStamp + " due to " + issue + ".";
                }
                if (service.equals(SubServicesTypes.SERVER_AVAILABILITY)) {
                    subject = "Proxy Server is unavailable";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that" + "\n\t" + serverName + " hosted on " + Host + " listening on Port " + port + " was reported inaccessible at " + timeStamp + " due to " + issue + ".";
                }
                if (service.equals(SubServicesTypes.PROXY_SERVER_TESTING)) {
                    subject = "Proxy Server is Down";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that" + "\n\t" + serverName + " hosted on " + Host + " was Down at " + timeStamp + " due to " + issue + ".";
                }
                sendEmailToUsers(proxyAccessLocalUserEmailAddresses);
                String populateQuery = "INSERT into alerts" + "(ID,server_name,Alerts)" + " VALUES (DEFAULT,'PROXY','" + messageText + "');";
                try {
                    PreparedStatement preparedStatement = con.prepareStatement(populateQuery);
                    preparedStatement.executeUpdate();
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            }
            if (serverType.equals(ServerTypes.WEB_SERVER)) {
                String selectQuery = "SELECT * FROM `web_server_info` WHERE Host_ip=INET_ATON('" + Host + "')";
                // execute the query, and get a java resultset
                ResultSet result = stmt.executeQuery(selectQuery);
                while (result.next()) {
                    serverName = result.getString("Server_name");
                    serverPort = result.getInt("Server_port");
                }
                selectQuery = "SELECT * FROM `user_accounts_info` WHERE Authorization_level='local' AND  webServer_Access='yes';";
                // execute the query, and get a java resultset
                result = stmt.executeQuery(selectQuery);
                while (result.next()) {
                    emailAddress = result.getString("Email");
                    webAccessLocalUserEmailAddresses[localWebCounter] = emailAddress;
                    localWebCounter++;
                }
                if (service.equals(SubServicesTypes.HOST_AVAILABILITY)) {
                    subject = "Web Server Host is not accessible";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that " + "\n\t" + serverName + " host " + Host + " was reported inaccessible  " + timeStamp + " due to " + issue + ".";
                }
                if (service.equals(SubServicesTypes.SERVER_AVAILABILITY)) {
                    subject = "Web Server is unavailable";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that " + "\n\t" + serverName + " hosted on " + Host + "  listening on Port " + port + " was reported inaccessible at " + timeStamp + " due to " + issue + ".";
                }
                if (service.equals(SubServicesTypes.WEB_SERVER_TESTING)) {
                    subject = "Web Server is Down";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that " + "\n\t" + serverName + " hosted on " + Host + " was Down at " + timeStamp + " due to " + issue + ".";
                }
                sendEmailToUsers(webAccessLocalUserEmailAddresses);
                String populateQuery = "INSERT into alerts" + "(ID,server_name,Alerts)" + " VALUES (DEFAULT,'WEB','" + messageText + "');";
                try {
                    PreparedStatement preparedStatement = con.prepareStatement(populateQuery);
                    preparedStatement.executeUpdate();
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            }
            if (serverType.equals(ServerTypes.DNS)) {
                String selectQuery = "SELECT * FROM `dns_info` WHERE Host_ip=INET_ATON('" + Host + "')";
                // execute the query, and get a java resultset
                ResultSet result = stmt.executeQuery(selectQuery);
                while (result.next()) {
                    serverName = result.getString("Server_name");
                    serverPort = result.getInt("Server_port");
                }
                selectQuery = "SELECT * FROM `user_accounts_info` WHERE Authorization_level='local' AND  dnsServer_Access='yes';";
                // execute the query, and get a java resultset
                result = stmt.executeQuery(selectQuery);
                while (result.next()) {
                    emailAddress = result.getString("Email");
                    DnsAccessLocalUserEmailAddresses[localDNSCounter] = emailAddress;
                    localDNSCounter++;
                }
                if (service.equals(SubServicesTypes.HOST_AVAILABILITY)) {
                    subject = "Domain Name Server Host is not accessible";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that " + "\n\t" + serverName + " host " + Host + " was reported inaccessible  at " + timeStamp + " due to " + issue + ".";
                }
                if (service.equals(SubServicesTypes.SERVER_AVAILABILITY)) {
                    subject = "Domain Name Server is unavailable";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that " + "\n\t" + serverName + " hosted on " + Host + "  listening on Port " + port + " was reported inaccessible  at " + timeStamp + " due to " + issue + ".";
                }
                if (service.equals(SubServicesTypes.DNS_TESTING)) {
                    subject = "Domain Name Server is Down";
                    messageText = "Dear user !" + "\n" + "I hope you will find this email in best of your health.The purpose to write this email is to convey that " + "\n\t" + serverName + " hosted on " + Host + " was Down at " + timeStamp + " due to " + issue + ".";
                }
                sendEmailToUsers(DnsAccessLocalUserEmailAddresses);
                String populateQuery = "INSERT into alerts" + "(ID,server_name,Alerts)" + " VALUES (DEFAULT,'DNS','" + messageText + "');";
                try {
                    PreparedStatement preparedStatement = con.prepareStatement(populateQuery);
                    preparedStatement.executeUpdate();
                } catch (SQLException e) {
                    e.printStackTrace();
                }
            }

            sendEmailToUsers(adminEmailAddresses);
        } catch (Exception ex) {
            System.out.println(ex);
        }

    }

    public void sendEmailToUsers(String[] usersEmailAddresses) {
        String host = "smtp.gmail.com";
        String user = "rsms.namal@gmail.com";
        String pass = "Namal123";
        String from = "rsms.namal@gmail.com";
        boolean sessionDebug = false;
        Properties props = System.getProperties();
        try {
            for (int i = 0; i < usersEmailAddresses.length; i++) {
                props.put("mail.smtp.starttls.enable", "true");
                props.put("mail.smtp.host", host);
                props.put("mail.smtp.port", "587");
                props.put("mail.smtp.auth", "true");
                props.put("mail.smtp.starttls.required", "true");
                java.security.Security.addProvider(new com.sun.net.ssl.internal.ssl.Provider());
                Session mailSession = Session.getDefaultInstance(props, null);
                mailSession.setDebug(sessionDebug);
                Message msg = new MimeMessage(mailSession);
                msg.setFrom(new InternetAddress(from));
                msg.setRecipients(Message.RecipientType.TO, InternetAddress.parse(usersEmailAddresses[i]));
                msg.setSubject(subject);
                msg.setSentDate(new Date());
                msg.setText(messageText);
                Transport transport = mailSession.getTransport("smtp");
                transport.connect(host, user, pass);
                transport.sendMessage(msg, msg.getAllRecipients());
                transport.close();
                System.out.println("Email Sent Successfully");
            }
        } catch (Exception e) {
            System.out.println(e);
        }

    }

    public static void main(String args[]) {
    }
}
