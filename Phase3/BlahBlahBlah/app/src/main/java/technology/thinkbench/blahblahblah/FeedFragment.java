package technology.thinkbench.blahblahblah;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v4.app.LoaderManager;
import android.support.v4.content.Loader;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.List;

import static android.preference.PreferenceManager.getDefaultSharedPreferences;


public class FeedFragment extends android.support.v4.app.Fragment implements LoaderManager.LoaderCallbacks<List<PostItem>>{

    public static final int POST_LOADER_ID = 2;

    /** Adapter for the list of earthquakes */
    private PostAdapter mAdapter;

    /** TextView that is displayed when the list is empty */
    private TextView mEmptyStateTextView;


    public FeedFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        final View rootView = inflater.inflate(R.layout.fragment_feed, container, false);

        mAdapter = new PostAdapter(this.getContext(), new ArrayList<PostItem>(), this);
        ListView featuredListView = (ListView) rootView.findViewById(R.id.list);

        mEmptyStateTextView = (TextView) rootView.findViewById(R.id.empty_view);
        featuredListView.setEmptyView(mEmptyStateTextView);

        featuredListView.setAdapter(mAdapter);

        LoaderManager loaderManager = getLoaderManager();
        loaderManager.initLoader(POST_LOADER_ID, null, this).forceLoad();

        Button button = (Button) rootView.findViewById(R.id.submit_post);

        final FeedFragment temp = this;

        View.OnClickListener buttonListener = new View.OnClickListener() {
            EditText newpost = (EditText) rootView.findViewById(R.id.my_thought);
            final FeedFragment ref = temp;

            @Override
            public void onClick(View v) {
                String args = "?type=post";
                SharedPreferences sharedPreferences = getDefaultSharedPreferences(rootView.getContext());
                int uid;
                String in = newpost.getText().toString().trim();
                args = args + "&body=" + in;
                if(sharedPreferences.contains("Uid")){
                    uid = sharedPreferences.getInt("Uid", 0);
                    args = args + "&uid=" + uid;
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
                newpost.setText("");
                CharSequence text = "Post Submitted!";
                Toast toast = Toast.makeText(rootView.getContext(), text, Toast.LENGTH_SHORT);
                toast.show();
                getLoaderManager().restartLoader(POST_LOADER_ID, null, ref).forceLoad();
            }
        };
        button.setOnClickListener(buttonListener);

        return rootView;
    }

    @Override
    public Loader<List<PostItem>> onCreateLoader(int i, Bundle bundle) {
        Log.d("DEBUG", "onCreateLoader: started post");
        String args = "?type=feed";

        SharedPreferences sharedPreferences = getDefaultSharedPreferences(this.getContext());
        int uid;
        if(sharedPreferences.contains("Uid")){
            uid = sharedPreferences.getInt("Uid", 0);
            args = args + "&uid=" + Integer.toString(uid);
        }

        return (new PostLoader(this.getContext(), args));
    }

    @Override
    public void onLoadFinished(Loader<List<PostItem>> loader, List<PostItem> posts) {
        Log.d("DEBUG", "onLoadFinished: post loader returned");

        // Hide loading indicator because the data has been loaded
        View loadingIndicator = getView().findViewById(R.id.loading_indicator);
        loadingIndicator.setVisibility(View.GONE);

        // Set empty state text to display
        mEmptyStateTextView.setText("No Results");

        // Clear the adapter
        mAdapter.clear();

        if (posts != null && !posts.isEmpty()) {
            mAdapter.addAll(posts);
        }
    }

    @Override
    public void onLoaderReset(Loader<List<PostItem>> loader){
        mAdapter.clear();
    }

}
