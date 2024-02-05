

    <section id="documentation">

      <section id="introduction">
        <h2>Introduction</h2>
        <article>
          <p class="paraEnhance">
            This is our enhancement, where we provide the innovative features for our features so as to improve website's standard for users
          </p>

        </article>
      </section>
      <section id="settings_admin">
        <h2>Settings for Website</h2>
        <article>
          <p class="paraEnhance">
            This is what we used to convert from the static data that user look at the website into dynamic, where we can change name, places, and links for social media and emails.
            We do not need to edit the php file by input the text box on the Settings-admin site, then once we click submit, 
            the data will be stored in the database and the data will display on the website.
          </p>

          <h3>Here is the list of top properties that we used to implement settings-admin:</h3>

          <ul>
            <li>We try to insert into our database first, only a record with primary key, but not foreign key and no reference to any table</li>
            <li>Similar to most of websites, we use $row means that array, then $row['name_columns'] to display data by mentioning name columns </li>
            <li>Some sort of things required like 'General Email', address, and site name. Other validation like regex for username in social media required when user input</li>
          </ul>
          <h3>Where we used it: </h3>
          <p>settings-admin.php (page) from url direction -> ./admin/settings-admin.php</a></p>
          <p>settingsController.php (controller) from url direction -> ./admin/controller/settingsController.php</a></p>
            <p>sidebarAdmin.php from folder fragment at admin, and footerFourcolumns.php, navbar.php in folder fragment that implement for displaying</p>
          <h3>References: </h3>
          <p>Inspiration: some sort of website like Wordpress and Opencart have the config where users can change the data for website appearance.</a>
          </p>


        </article>
      </section>
      <section id="logout_page">
        <h2>Logout page</h2>
        <article>
          <p class="paraEnhance">
            This is the page where we use to logout the user, when they click logout, 
            the session name 'user' ($_SESSION['user']) will be destroyed and the user will be redirected to the login page.
            We also use the session to check whether the user is logged in or not, if the user is not logged in, they will be redirected to the login page.
            If user logged in before, if they click to login, reset password page, they will automatically redirect to manage.php, even the navbar login changes to manage
          </p>
          <h3>The list of top properties in css that we used for logout page</h3>
          <ul>
            <li>!isset($_SESSION['user']):   If the user is not logged in, redirect to login page</li>
            <li>unset($_SESSION['user']):  If the user is logged in, unset only the 'user' session variable</li>
            <li>include './controller/authCheck.php'; Including authentication check </li>
          </ul>
          <h3>Where we used it: </h3>
          <p>in every top of the line at folder admin (not sub-folder)</p>
        </article>
      </section>
      <section id="normalise_table">
        <h2>Normalise table: eoi_skill, jobDesc_skill, eoi, skill, jobDesc, staff</h2>
        <article>
          <p class="paraEnhance">
          <strong> One to many: </strong>
          <br>
            Between eoi and jobDesc, we have the relationship one to many means that some eoi can belong to one record at jobDesc,
             and vice versa, so we need to create the table eoi_skill and jobDesc_skill to normalise the data. Similar to jobDesc and staff tables,
             <br>
             <strong> Many to many: </strong>
             <br>
            Between eoi and skill, there is a table called eoi_skill which demonstrate the many to many relationship, 
            means that many skills record can belong to many eoi record, and vice versa.  
          </p>
        </article>
      </section>

      <section id="third_party_sites">
        <h2>Acknowledgement</h2>

        <h3>Third party sites</h3>
        <ul>
          <li>CSS alert: <a href="https://codepen.io/rlemon/pen/krxjpB/" target="_blank" rel="noopener noreferrer">Here!</a></li>
          <li>Filter searching table using js:
            <a href="https://www.w3schools.com/howto/howto_js_filter_table.asp" target="_blank" rel="noopener noreferrer">Here!</a></li>
          <li>Select - Dropdown - Veiko:
            <a href="https://codepen.io/vkjgr/pen/VYMeXp" target="_blank" rel="noopener noreferrer">Here!</a>
          </li>
          <li>Responsive Form - Md Aminul Hoque <a href="https://codepen.io/gem007bd/pen/vpebEY" target="_blank" rel="noopener noreferrer">Here!</a>
          </li>
          <li>Creating login page in html and css - www.scaler.com:
            <a href="https://www.scaler.com/topics/login-page-in-html/" target="_blank" rel="noopener noreferrer">Here!</a> </li>
        </ul>
      </section>


    </section>
