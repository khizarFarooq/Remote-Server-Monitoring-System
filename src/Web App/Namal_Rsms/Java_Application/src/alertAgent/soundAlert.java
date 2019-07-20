package alertAgent;

import java.io.*;
import sun.audio.*;
public class soundAlert
{
    public void throwSoundAlert(){
        // open the sound file as a Java input stream
        String gongFile = "E:\\Khizar Dogar\\Final Year\\FYP\\Final Submission\\Java_Application\\src\\alertAgent\\alert.wav";
        InputStream in = null;
        AudioStream audioStream;
        try {
            in = new FileInputStream(gongFile);
            // create an audiostream from the inputstream
            audioStream = new AudioStream(in);
            // play the audio clip with the audioplayer class
            AudioPlayer.player.start(audioStream);
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }


    }
    public static void main(String[] args)

    {

    }
}