################################################## CHANGES: ########################################################

--------- DB -----------

I've made changes for the memo db where I removed the 'announcement_id' since announcement is the one that attaches memos with its announcements and renamed the table from 'memo_repo' to 'memo':
+------+------------------------------------------------+-------+
| 				memo				|
+------+------------------------------------------------+-------+
| PK   | memo_id                                        	|
+------+------------------------------------------------+-------+
|      | title							|
|      | short_desc						|
|      | file_path						|
|      | effectivity_date				        |
|      | issued_date				        	|
|      | created_at				        	|
|      | updated_at				        	|
+------+------------------------------------------------+-------+

------- ADDED CONFIGURATIONS ----------

> I've stored my memo files in a folder called 'memoFiles' in a public folder by the following path:
storage/app/public/memoFiles

!!NOTE: In order to manipulate this folder with the backend or maybe you have trouble testing the upload file feature, link the storage by typing this in your directory:

"php artisan storage:link"

> I also installed moment.js to format the date in 'Posted Date' since the format is in timestamp:
"npm install moment --save"

More information regarding moment.js here: "https://momentjs.com/"

> I also installed vue-expandable-image to expand the view of an image to full size on hover on Memo Details
"npm install vue-expandable-image"

More information regarding vue-expandable-image here: "https://vuejsexamples.com/a-vue-component-that-allows-your-images-to-open-in-full-size/"