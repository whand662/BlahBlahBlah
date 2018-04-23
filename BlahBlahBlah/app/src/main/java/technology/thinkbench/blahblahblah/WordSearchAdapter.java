package technology.thinkbench.blahblahblah;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;
import java.util.ArrayList;

/**
 * Created by willis on 4/18/18.
 */

public class WordSearchAdapter extends ArrayAdapter<WordSearchItem> {

    public WordSearchAdapter(Context context, ArrayList<WordSearchItem> WordItems) {
        super(context, -1, new ArrayList<WordSearchItem>());
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        // Check if there is an existing list item view (called convertView) that we can reuse,
        // otherwise, if convertView is null, then inflate a new list item layout.
        View listItemView = convertView;
        if (listItemView == null) {
            listItemView = LayoutInflater.from(getContext()).inflate(
                    R.layout.word_search_item, parent, false);
        }

        WordSearchItem currentWord = getItem(position);

        // City
        TextView cityView = (TextView) listItemView.findViewById(R.id.word_location);
        cityView.setText(currentWord.getCity());

        // Occurences
        TextView occurencesView = (TextView) listItemView.findViewById(R.id.word_occurences);
        occurencesView.setText(Integer.toString(currentWord.getOccurences()));

        // Return the list item view that is now showing the appropriate data
        return listItemView;
    }

}
