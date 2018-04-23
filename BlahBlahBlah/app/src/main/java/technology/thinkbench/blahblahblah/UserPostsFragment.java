package technology.thinkbench.blahblahblah;

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


public class UserPostsFragment extends android.support.v4.app.Fragment implements LoaderManager.LoaderCallbacks<List<PostItem>>{

    public static final int USER_POST_LOADER_ID = 3;

    /** Adapter for the list of earthquakes */
    private UserPostAdapter mAdapter;

    /** TextView that is displayed when the list is empty */
    private TextView mEmptyStateTextView;

    String lastSearched = "";


    public UserPostsFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        final View rootView = inflater.inflate(R.layout.fragment_user_posts, container, false);

        mAdapter = new UserPostAdapter(this.getContext(), new ArrayList<PostItem>(), this);
        ListView featuredListView = (ListView) rootView.findViewById(R.id.list);

        mEmptyStateTextView = (TextView) rootView.findViewById(R.id.empty_view);
        featuredListView.setEmptyView(mEmptyStateTextView);

        featuredListView.setAdapter(mAdapter);

        Button button = (Button) rootView.findViewById(R.id.search_user);

        final UserPostsFragment temp = this;

        View.OnClickListener buttonListener = new View.OnClickListener() {
            EditText username = (EditText) rootView.findViewById(R.id.enter_username);
            final UserPostsFragment ref = temp;

            @Override
            public void onClick(View v) {
                String in = username.getText().toString().trim();
                lastSearched = in;
                LoaderManager loaderManager = ref.getLoaderManager();
                if(lastSearched.equalsIgnoreCase("")){
                    Toast toast = Toast.makeText(rootView.getContext(), "Enter a username to search for", Toast.LENGTH_SHORT);
                    toast.show();
                    username.requestFocus();
                }else{
                    CharSequence text = "Search submitted!";
                    Toast toast = Toast.makeText(rootView.getContext(), text, Toast.LENGTH_SHORT);
                    toast.show();
                    loaderManager.restartLoader(USER_POST_LOADER_ID, null, ref).forceLoad();
                }
            }
        };
        button.setOnClickListener(buttonListener);

        return rootView;
    }

    @Override
    public Loader<List<PostItem>> onCreateLoader(int i, Bundle bundle) {
        Log.d("DEBUG", "onCreateLoader: started searching for user posts");
        String args = "?type=postsbyuser&user=" + lastSearched;

        return (new PostLoader(this.getContext(), args));
    }

    @Override
    public void onLoadFinished(Loader<List<PostItem>> loader, List<PostItem> posts) {
        Log.d("DEBUG", "onLoadFinished: post loader returned");

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
