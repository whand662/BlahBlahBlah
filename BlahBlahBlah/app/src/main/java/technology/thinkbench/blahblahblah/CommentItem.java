package technology.thinkbench.blahblahblah;

import android.support.annotation.NonNull;

import com.google.gson.JsonObject;
import com.google.gson.JsonParser;

public class CommentItem implements Comparable<CommentItem> {
    private String author = "";
    private String timestamp = "";
    private String blurb = "";

    public CommentItem(){
        author = "whand";
        timestamp = "never";
        blurb = "This is a blurb";
    }

    public CommentItem(String a, String ts, String b) {
        author = a;
        timestamp = ts;
        blurb = b;
    }

    public CommentItem(String json){
        JsonObject j = (new JsonParser()).parse(json).getAsJsonObject();
        author = j.get("username").getAsString();
        timestamp = j.get("comment_time").getAsString();
        blurb = j.get("body").getAsString();
    }

    public String getAuthor() {
        return author;
    }

    public String getTimestamp() {return timestamp;}

    public String getBlurb() {
        return blurb;
    }

    @Override
    public int compareTo(@NonNull CommentItem o) {
        return timestamp.compareTo(o.getTimestamp());
    }

}