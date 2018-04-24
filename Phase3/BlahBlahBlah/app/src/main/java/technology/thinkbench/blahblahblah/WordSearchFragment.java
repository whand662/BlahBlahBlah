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

public class WordSearchFragment extends android.support.v4.app.Fragment implements LoaderManager.LoaderCallbacks<List<WordSearchItem>>{

    public static final int WORD_LOADER_ID = 4;

    /** Adapter for the list of earthquakes */
    private WordSearchAdapter mAdapter;

    /** TextView that is displayed when the list is empty */
    private TextView mEmptyStateTextView;

    String lastSearched = "";

    public WordSearchFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        final View rootView = inflater.inflate(R.layout.fragment_word_search, container, false);

        mAdapter = new WordSearchAdapter(this.getContext(), new ArrayList<WordSearchItem>());
        ListView featuredListView = (ListView) rootView.findViewById(R.id.list);

        mEmptyStateTextView = (TextView) rootView.findViewById(R.id.empty_view);
        featuredListView.setEmptyView(mEmptyStateTextView);

        featuredListView.setAdapter(mAdapter);

        Button button = (Button) rootView.findViewById(R.id.search_word);

        final WordSearchFragment temp = this;

        View.OnClickListener buttonListener = new View.OnClickListener() {
            EditText username = (EditText) rootView.findViewById(R.id.enter_word);
            final WordSearchFragment ref = temp;

            @Override
            public void onClick(View v) {
                String in = username.getText().toString().trim();
                lastSearched = in;
                LoaderManager loaderManager = ref.getLoaderManager();
                if(lastSearched.equalsIgnoreCase("")){
                    Toast toast = Toast.makeText(rootView.getContext(), "Enter a word to search for", Toast.LENGTH_SHORT);
                    toast.show();
                    username.requestFocus();
                }else{
                    CharSequence text = "Search submitted!";
                    Toast toast = Toast.makeText(rootView.getContext(), text, Toast.LENGTH_SHORT);
                    toast.show();
                    loaderManager.restartLoader(WORD_LOADER_ID, null, ref).forceLoad();
                }
            }
        };
        button.setOnClickListener(buttonListener);

        return rootView;
    }

    @Override
    public Loader<List<WordSearchItem>> onCreateLoader(int i, Bundle bundle) {
        Log.d("DEBUG", "onCreateLoader: started searching for user posts");
        String args = "?type=wordsearch&criteria=" + lastSearched;

        return (new WordSearchLoader(this.getContext(), args));
    }

    @Override
    public void onLoadFinished(Loader<List<WordSearchItem>> loader, List<WordSearchItem> posts) {
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
    public void onLoaderReset(Loader<List<WordSearchItem>> loader){
        mAdapter.clear();
    }

}
