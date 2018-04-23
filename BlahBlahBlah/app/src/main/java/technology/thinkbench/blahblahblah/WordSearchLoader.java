package technology.thinkbench.blahblahblah;

import android.content.Context;
import android.support.v4.content.AsyncTaskLoader;
import android.util.Log;

import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

/**
 * Created by willis on 4/18/18.
 */

public class WordSearchLoader extends AsyncTaskLoader<List<WordSearchItem>> {

    private String args;

    public WordSearchLoader(Context context, String a) {
        super(context);
        args = a;
    }

    @Override
    public List<WordSearchItem> loadInBackground() {
        if (args == null) {
            return null;
        }

        List<WordSearchItem> results = new ArrayList<WordSearchItem>();

        try{
            String getreturn = RESTimp.sendGet(args);
            JsonObject jsonObject = (new JsonParser()).parse(getreturn).getAsJsonObject();
            JsonArray JA = jsonObject.getAsJsonArray("data");
            if(JA.size() == 0){
                return null;
            }
            Log.d("DEBUG", "Return array has: " + String.valueOf(JA.size()));
            String temp2;
            for(int i = 0; i < JA.size(); i++){
                JsonElement temp1 = JA.get(i);
                temp2 = temp1.toString();
                results.add(new WordSearchItem(temp2));
            }
        }catch (Exception e){
            Log.d("DEBUG", "loadInBackground: caught exception " + e.getMessage());
            return null;
        }
        Collections.sort(results);
        return results;
    }

}