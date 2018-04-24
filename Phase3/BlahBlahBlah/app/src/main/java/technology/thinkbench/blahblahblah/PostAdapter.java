package technology.thinkbench.blahblahblah;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import java.util.ArrayList;

import static android.preference.PreferenceManager.getDefaultSharedPreferences;

public class PostAdapter extends ArrayAdapter<PostItem> {

    final FeedFragment ref;

    public PostAdapter(Context context, ArrayList<PostItem> PostItems, FeedFragment temp) {
        super(context, -1, new ArrayList<PostItem>());
        ref = temp;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        // Check if there is an existing list item view (called convertView) that we can reuse,
        // otherwise, if convertView is null, then inflate a new list item layout.
        View listItemView = convertView;
        if (listItemView == null) {
            listItemView = LayoutInflater.from(getContext()).inflate(
                    R.layout.post_item, parent, false);
        }

        final PostItem currentPost = getItem(position);

        // Author
        TextView authorView = (TextView) listItemView.findViewById(R.id.post_author);
        authorView.setText(currentPost.getAuthor());

        // Post
        TextView blurbView = (TextView) listItemView.findViewById(R.id.post_blurb);
        blurbView.setText(currentPost.getBlurb());

        // Timestamp
        TextView tsView = (TextView) listItemView.findViewById(R.id.post_timestamp);
        tsView.setText(currentPost.getTimestamp());

        LinearLayout list = (LinearLayout) listItemView.findViewById(R.id.comments);
        list.removeAllViews();
        for (CommentItem comment : currentPost.getComments()) {
            LayoutInflater inflater = (LayoutInflater)   getContext().getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            View line = inflater.inflate(R.layout.comment_item, null);

            // Author
            TextView aView = (TextView) line.findViewById(R.id.post_author);
            aView.setText(comment.getAuthor());

            // Post
            TextView bView = (TextView) line.findViewById(R.id.post_blurb);
            bView.setText(comment.getBlurb());

            // Timestamp
            TextView tView = (TextView) line.findViewById(R.id.post_timestamp);
            tView.setText(comment.getTimestamp());

            list.addView(line);
        }

        final Button button = (Button) listItemView.findViewById(R.id.submit_comment);

        final View finalListItemView = listItemView;
        View.OnClickListener buttonListener = new View.OnClickListener() {
            int tid = currentPost.getTid();
            EditText input = (EditText) finalListItemView.findViewById(R.id.new_comment);

            @Override
            public void onClick(View v) {
                String args = "?type=comment";
                SharedPreferences sharedPreferences = getDefaultSharedPreferences(input.getContext());
                int uid;
                String in = input.getText().toString().trim();
                args = args + "&body=" + in + "&tid=" + Integer.toString(tid);
                if(sharedPreferences.contains("Uid")){
                    uid = sharedPreferences.getInt("Uid", 0);
                    args = args + "&uid=" + Integer.toString(uid);
                }
                try {
                    final String finalArgs = args;
                    new Thread() {
                        public void run() {
                            String response = null;
                            try {
                                response = RESTimp.sendGet(finalArgs);
                            } catch (Exception e) {
                                e.printStackTrace();
                            }
                            Log.d("DEBUG", response);
                        }
                    }.start();
                } catch (Exception exc) {
                    // could do better by treating the different sax/xml exceptions individually
                    Log.d("DEBUG", "in exception", exc);
                }
                input.setText("");
                CharSequence text = "Comment Submitted!";
                Toast toast = Toast.makeText(input.getContext(), text, Toast.LENGTH_SHORT);
                toast.show();
                ref.getLoaderManager().restartLoader(ref.POST_LOADER_ID, null, ref).forceLoad();
            }
        };
        button.setOnClickListener(buttonListener);

        // Return the list item view that is now showing the appropriate data
        return listItemView;
    }
}