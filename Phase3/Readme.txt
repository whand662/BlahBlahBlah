File descriptions for phase 3

LOG_REST.php
This file is the interface between the app and the DB. GET requests are sent from the app that specify which query to perform, along with any additional parameters. Then the REST creates a connection to the DB and executes the query, returning the result in JSON form.

RESTimp.java & DownloadIntentService.java
RESTimp.java is the file that knows how to send a request to to localhost/LOG_REST.php. However since networking can't be run on the main thread in android it must be wrapped in another service that runs on its own thread. This is what DownloadIntentService does.

CentralActivity.java & *Fragment.java
CentralActivity is the main activity of the app, it is essentially a container that mounts all of the fragments inside itself.

*Loader.java
The custom loaders are used to handle the download requests to the DB, and then to update the fragment accordingly.

*Adapter.java
The adapters are what specifically build the layout of the app when the data has been returned from the REST implementation.

LoginActivity.java & MakeAccountActivity.java
These handle the login and make account screens.

res/layout/*.xml
These are the layout files for each of the activites and fragments.
