package technology.thinkbench.blahblahblah;

import android.support.annotation.NonNull;

import com.google.gson.JsonObject;
import com.google.gson.JsonParser;

/**
 * Created by willis on 4/18/18.
 */

public class WordSearchItem implements Comparable<WordSearchItem>{

    private String city = "";
    private int occurences = 0;

    public WordSearchItem(){
        city = "nowhere";
    }

    public WordSearchItem(String c, int o) {
        city = c;
        occurences = o;
    }

    public WordSearchItem(String json){
        JsonObject j = (new JsonParser()).parse(json).getAsJsonObject();
        city = j.get("Location").getAsString();
        occurences = j.get("Occurences").getAsInt();
    }

    public String getCity() {
        return city;
    }

    public int getOccurences() {return occurences;}

    @Override
    public int compareTo(@NonNull WordSearchItem o) {
        if(occurences > o.getOccurences()){
            return 1;
        }else if(occurences < o.getOccurences()){
            return -1;
        }

        return 0;
    }
}
