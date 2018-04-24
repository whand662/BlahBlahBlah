package technology.thinkbench.blahblahblah;

import android.support.annotation.NonNull;
import android.util.Log;

import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import com.google.gson.JsonElement;

import java.util.ArrayList;
import java.util.Collections;

public class PostItem implements Comparable<PostItem> {
    private String author = "";
    private String timestamp = "";
    private String blurb = "";
    private int tid;
    private ArrayList<CommentItem> comments = new ArrayList<CommentItem>();

    public PostItem(){
        author = "whand";
        timestamp = "never";
        blurb = "This is a blurb";
        tid = -1;
    }

    public PostItem(String a, String ts, String b, int i) {
        author = a;
        timestamp = ts;
        blurb = b;
        tid = i;
    }

    public PostItem(String json){
        JsonObject j = (new JsonParser()).parse(json).getAsJsonObject();
        author = j.get("username").getAsString();
        timestamp = j.get("post_time").getAsString();
        blurb = j.get("body").getAsString();
        tid = j.get("tid").getAsInt();

        try {
            JsonArray JA = j.getAsJsonArray("comments");
            if (JA.size() > 0) {
                Log.d("DEBUG", "Number of comments: " + String.valueOf(JA.size()));
                String temp;
                for (int i = 0; i < JA.size(); i++) {
                    JsonElement temp1 = JA.get(i);
                    temp = temp1.toString();
                    comments.add(new CommentItem(temp));
                }
                Collections.sort(comments);
            }
        }catch (Exception e){
            Log.d("DEBUG", "PostItem Constructor: caught exception " + e.getMessage());
        }
    }

    public String getAuthor() {
        return author;
    }

    public String getTimestamp() {return timestamp;}

    public String getBlurb() {
        return blurb;
    }

    public int getTid() {
        return tid;
    }

    public int commentCount(){
        return comments.size();
    }

    public ArrayList<CommentItem> getComments(){
        return comments;
    }

    @Override
    public int compareTo(@NonNull PostItem o) {
        return o.getTimestamp().compareTo(timestamp);
    }

}