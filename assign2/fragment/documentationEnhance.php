<section id="documentation">

      <section id="introduction">
        <h2>Introduction</h2>
        <article>
          <p class="paraEnhance">
            This is the enhancement, where we add the best features for our website in order to make the website provide
            the best experience for users
          </p>

        </article>
      </section>
      <section id="carousel_manual">
        <h2>Carousel Manual Click - HTML feature</h2>
        <article>
          <p class="paraEnhance">
            This is the feature that includes in index.html, the carousel is a slideshow for moving through a series of
            content and return, built with html and css. It helps people to see each picture alongside its brief
            information. When they click the right-arrow or left-arrow or click any rounded button in the middle bottom,
            user will see the corresponding number of the picture with the brief text in
            the bottom left of the picture.
          </p>

          <h3>Here is the list of top properties that we used to implement slider carousel:</h3>

          <ul>
            <li>variable - which only used for representing colors, so that this will reduce the number of syntax color
              and background color using the specific color code</li>
            <li>:checked - this is the selector which represent radio buttons when they are checked or being toggled by
              a user </li>
            <li>(~) tilde: this is the combinator in CSS that selects the sibling elements of a specified element, when
              the tlide uses the last sibling will be activated</li>
          </ul>
          <h3>Where we used it: </h3>
          <p>line: 248 - 290 in HTML and line 740 - 873 in CSS</p>
          <h3>References: </h3>
          <p>The carousel that Phong took from his Github profile: https://github.com/Phonginhere/covidminiproject</a>
          </p>


        </article>
      </section>
      <section id="infinite_autoplay_c">
        <h2>Infinite Autoplay Carousel - HTML feature</h2>
        <article>
          <p class="paraEnhance">
            It will display automatically to the visitors some of the famous brands that collaborate with l:on It
            company. This is will increase the users' trust from the IT company because of the top-notch brands.
          </p>
          <h3>The list of top properties in css that we used for Infinite Autoplay Carousel</h3>
          <ul>
            <li>@keyframes: This is actually we use for moving the item, when we use animation: scroll 40s, the name
              scroll need to be simliar for the @keyscroll: @keyframes scroll, so that the item will be move the
              direction with the keywords "from" and "to"</li>
            <li>calc: This is actually the calculation, example calc(270px * 14), the total calculation will be the
              number for the properties</li>
            <li>animation: This is the properties that uses for animating the element, "animation: scroll 35s infinite"
              means that animation use the name scroll to bind in other properties like @keyframes, 35 seconds means
              that the animaiton will last for 4 seconds </li>
          </ul>
          <h3>Where we used it: </h3>
          <p>line 705 - 634 in css and line 186 - 242 in html</p>
          <h3>References:</h3>
          <p>Infinite Auto Play Carousel - Codepen: https://codepen.io/studiojvla/pen/qVbQqW</p>
        </article>
      </section>
      <section id="variable_var_root">
        <h2>Variable - var() - ::root / CSS feature</h2>
        <article>
          <p class="paraEnhance">
            In order to reduce the number of color or background-color properties that use with the color code, variable
            is the best because it can access to every properties since css variables becomes global or local. When it
            comes to :root selector, any variable creates inside that will become global and it can assign to any
            properties in the css file.
            <strong> Example </strong>
          </p>
          <h3>Where we used it</h3>
          <ul>
            <li>:root: Line 743 - 750 in css</li>
            <li>var(): Line 756 - 1268 in css (mostly)</li>
          </ul>
        </article>
      </section>
      <section id="responsive_css">
        <h2>Responsive</h2>
        <p class="paraEnhance">
          What we love is that not only we make the web have a good-looking for desktop users, but also the people who
          use website in different platforms, such as ipad and mobile. Responsive is a good enhancement allows different
          elements from text, image, navbar header, navbar-left, carousel, footer, table, will proportionally fit depend
          on how user use their own devices. This will improve the user experience by having them be able to clearly
          look whatever devices they use.
        </p>
        <h3>We achieved that by:</h3>
        <ul>
          <li>viewport meta tag: This will make the browser changed from the image and text, relying on how the user
            pulls out and in </li>
          <li>max-width: 74em means that, it never scale up to be larger than the element original size at 74em, if
            lower than 74em, the media block will apply</li>
          <li>min-width: 72.01em means that, it will apply when the screen width is greater or equal than 72.01em </li>
          <li>only screen: This keyword is used to hinder older browsers, which do not support media queries from
            appling the specific styles</li>
        </ul>
        <h3>Where we used it</h3>
        <ul>
          <li>Line 123 - 175 for navigation bar</li>
          <li>Line 535 - 543 for gallery section</li>
          <li>Line 545 - 540 for slider autocarousel</li>
          <li>Line 552 - 576 for banner, about and job sections</li>
          <li>Line 583 - 590 for specific images from gallery section and slider auto carousel</li>
          <li>Line 881 - 899 for footer 4 columns</li>
          <li>Line 1231 - 1270 for slider autocarousel, sidebar and documentation right side of the enhancement page
          </li>
          <li>Line 1272 - 1276 for documentation right side of the enhancement page</li>
        </ul>
      </section>

      <section id="third_party_sites">
        <h2>Acknowledgement</h2>

        <h3>Third party sites</h3>
        <ul>
          <li>Unsplash for images: https://unsplash.com/</li>
          <li>Bluene Free website - Inspiration for the design of our website:
            https://www.free-css.com/free-css-templates/page289/bluene</li>
          <li>Enhancement page: Technical documentation project - Vinay Khatri:
            https://codepen.io/vinay-khatri/pen/bGKdBXx?fbclid=IwAR0GimFMeAb7I44q24vuM6Fh7AEyx9JmE4QGic0IDYjPYiA1EGB-GJ56xmw
          </li>
          <li>Overlay text for video: HTML5 Video Overlay Text -codeconvey: https://codepen.io/codeconvey/pen/rjOxON
          </li>
          <li>Data for job description: Seek website - job search:
            https://www.seek.com.au/job/69759781?type=standard#sol=4e5ac84a0328c37a09aabd46687ce1b37185c1be</li>
          <li> Colorwave - W3school
          </li>
          <li>Navigation bar - w3bits.com: https://w3bits.com/css-responsive-nav-menu/</li>
          <li>Footer: Footer 4 columns: https://codepen.io/tombyers/pen/bEgrKq</li>
        </ul>
      </section>


    </section>
