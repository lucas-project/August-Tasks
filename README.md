# Developer Notes: Practical Exercise

### You can also access this document here, might help you read faster, sometimes
[https://docs.google.com/document/d/1K5IbmNTkyHaFL1_wawHzJokFmr7carE7ZdTTKNQrFoc/edit?usp=sharing](https://docs.google.com/document/d/1K5IbmNTkyHaFL1_wawHzJokFmr7carE7ZdTTKNQrFoc/edit?usp=sharing)

---

### Development Key Web Addresses
- [http://localhost:8080/](http://localhost:8080/)
- [http://localhost:8080/?post_type=song](http://localhost:8080/?post_type=song)
- [http://localhost:8080/?song=song-3](http://localhost:8080/?song=song-3)

### To start docker, run:
```
docker-compose up -d
```

### To start composer installing:
```
docker-compose exec wordpress composer install
```
*Or try*
```
docker-compose exec wordpress composer require wpackagist-plugin/advanced-custom-fields
```

### To update composer installation after altering:
```
docker-compose exec wordpress composer update
```
Or try
```
docker-compose exec wordpress composer update lucas-project/songs-plugin
```

### To use shortcode:
```
[song_contact_form]
```

---

## Task One - Create a WordPress Plugin

*Create a WordPress plugin that provides the following:*

### 1. A custom post type that only WordPress Admin users can manage. Please name this custom post type "Songs".

**Challenges and thinking process:**

1.  What does Wordpress's project structure look like? What are each folders used for?
2.  Should I create a new website then use a template then start my custom plugin development?
3.  What are some common good practice in Wordpress development
4.  What is custom post type and taxonomy, how they relate to each together
5.  Understanding the way wordpress works with both dashboard and code is important to me, as well as how post type and taxonomy visually looks like.

**Questions to ask:**

1.  Should I create a new website then use a template then start my custom plugin development?
2.  Should the Songs post type have any specific custom fields or meta boxes?
3.  Are there any specific capabilities beyond the default that should be associated with the Songs post type?
4.  Should the Genre taxonomy be hierarchical (like categories) or non-hierarchical (like tags)?
5.  What are some contents that the post type ‘Songs’ needs to have, also, what will be in the meta box and any specific fields?

**Any reference:**
Then I need to have some understanding of the general process of developing a custom post type, and I found these links particularly helpful, my intention here is to find some example of how this is implemented like I did in my other project, I hope to find some code snippets as my skeleton to build on:

-   [How to create a WordPress custom post type: what it is and its customization](https://www.hostinger.com/tutorials/wordpress-custom-post-types)
    (lot of details on $args, $labels, $supports)

    This post came with a lot of useful details, including the basic concept of post type, what are those elements in its $args, $labels, $support array means, it provided a Custom Article post type snippet, which I used in my code to get started. And it introduced adding meta box to custom’ post type, I also used this part of the code in my task, I then modify the code to add some custom meta information to my own ‘Songs’ post type, the HTML part of its meta box part was not right, I changed it to used ‘\<table>’ element, and I added some relevant information like author\_name, release\_date, etc. according to instructions from the email. The post also introduced how to display custom plugins and custom fields in the webpage.

**How are Chatgpt helped in this part?**
I used AI to created .gitignore
Set up development environment using docker, writing .yml file

---

### 2. A new Taxonomy to use with the custom post type, again only Admin users should be able to manage. Please name your Taxonomy, "Genre" with a default term "Classical".

**Challenges and thinking process:**

1.  What is Taxonomy, how does it relate to custom post type? I need to visually see how it looks like to understand, especially with a default classification
2.  Where should I place my Taxonomy code?
3.  How do wordpress manage users' permissions?
4.  What is add\_action()? What are some common wordpress hooks and classes?
5.  What is the difference between a meta box and custom field? Why is my custom field displaying meta box information?
6.  I can see the taxonomy and the new post type in the dashboard, how can I display them in my webpage?
7.  What are archive templates and single templates?

**Questions to ask:**

1.  Should the Genre taxonomy be hierarchical (like categories) or non-hierarchical (like tags)?
2.  Should every song created use the default ‘Classical’ type or just leave it there?

**Any reference?**
I had a really quick reply from Simon and Matt, then I can start my work. I start googling around, and found these links particularly useful:

-   [WordPress taxonomy: what it is, and how to create custom taxonomies](https://www.hostinger.com/tutorials/wordpress-taxonomy)
    This post is the foundation of my code, there was a code example of hierarchical taxonomy, which is simple and clear, I built my code on it. Besides, the post also introduce basic concepts of taxonomy, different types of taxonomy (tag, category, etc.) with visual.

-   [How to Create WordPress Custom Post Type (CPT) and Taxonomy – Hello World Tutorial, Tips and Tricks](https://crunchify.com/how-to-create-wordpress-custom-post-type-cpt-and-taxonomy-hello-world-tutorial-tips-and-tricks/)
    (It shows how custom taxonomy connect with custom post type)
    This post is also important to me, because it shows me how taxonomy actually relates to custom post type, it has a complete example of how to build a custom type, a taxonomy, then relate them. And the code snippets it provided are so similar to what I had previously, when you find two things in a similar pattern, it actually reinforces the understanding of it, unless they are quite different, that means you only knew very little about it and still needs more effort to find out.

-   [How to Create Custom Taxonomies in WordPress](https://www.wpbeginner.com/wp-tutorials/create-custom-taxonomies-wordpress/)
    This post gives me another method of creating custom taxonomy, which is by using WPcode plugin to add code snippets and using admin dashboard.

After creating the basic version of custom post type and taxonomy, I still need to add admin users permission and display my custom plugin and taxonomy on the webpage. I didn’t do this part until after task 2, because based on experience on other frameworks, adding authentication is not very difficult, but it might bring trouble for development. In the end I found I was wrong, Wordpress has its own way to manage users. I found this link is useful:

-   [The Ultimate Guide to WordPress User Roles and Capabilities](https://kinsta.com/blog/wordpress-user-roles/)
    This post Wordpress user roles and their capabilities and provided detailed code examples of how to manage permissions.

**How are Chatgpt helped in this part?**
Created basic CSS styling for meta box
Fixed a few bugs, missing bracket, unmatch names
Added missing frontend verification and sanitisation

---

## Task Two - Create an update to your WordPress Plugin
*Add the following new functionality in your updated plugin:*

### 1. A short code which Authors can use to insert a HTML form into their content. The form should include a name and email field, along with a submit button.

**Challenges and thinking process:**

1.  What is short code? What is it used for? What does it look like? Where should I place my shortcode?
2.  I assume this might very similar to Restful I familiar with, the frontend has a form with action, then after submitting, some kind of javascript that is listening to the action triggered and handle the value sent by the form, then sent it to backend through an agreed URL, when backend detect the URL, it handle the data through assigned callback. Roughly like this, and also some details like sanitization, security, etc.
3.  What Wordpress methods are commonly used to ensure form data security?
4.  Is this available to any user? Does it inherit the permissions from the plugin? How to ensure security?

**Questions to ask:**

1.  It seems like I need to place those shortcodes and form handling code inside of the custom plugin 'Songs', but I felt like they are not quite related in terms of functionality, should I do that?

**Any reference?**
I have found some links that is very helpful in this task as well:

-   [How To Create Your Own WordPress Shortcode - Part 1](https://www.youtube.com/watch?v=9GwrmbC94Es)
    This video directly answers my first question, it shows what a shortcode looks like and how to create a simple short code from zero, which is helpful for me to get started. The example it uses is printing out a string, which is different from me, I need to create a form.

-   [How To Create Your Own WordPress Shortcode - Part 2](https://www.youtube.com/watch?v=krgQuNn67AY)
    These two videos belong to the same series, this part introduced shortcode’s attribute, for example how to execute the code multiple times. It is not directly applicable to my tasks, but it is a good way to expand my knowledge here.

-   [How to create a shortcode in WordPress (in 7 steps)](https://www.hostinger.com/tutorials/create-a-shortcode-in-wordpress)
    This post provides a very good example of how to implement a shortcode with attributes.

**How are Chatgpt helped in this part?**
Asked about difference between template and post, and how to add shortcode to them

---

### 2. An example REST endpoint that could be used to handle a form Submission.

**Challenges and thinking process:**

1.  I need to use JavaScript to handle form data and send it to the backend via Ajax, where should I place my code?
2.  How to define route in Wordpress, does Wordpress have its own method or convention to define a route?
3.  What Wordpress APIs or Classes I can use in sending requests, handling data and saving data?
4.  How to ensure security of my API?

**Questions to ask:**

1.  When users submit their info through the shortcode form, do you have a preferred route for where that data should go? My plan is to save the submission as a new post type in the database, using the route custom\_song/v1. Does that approach work for you, or would you prefer something different?
2.  Once the form is submitted, I was thinking of showing a success/ error message on the same page without reloading. Do you have any preference of how users are notified of the result of the submission?

**Any reference?**

-   [WordPress REST API guide: understand how to set it up and use it in 2025](https://www.hostinger.com/tutorials/wordpress-rest-api)
    (help understanding of code)

**How are Chatgpt helped in this part?**
I am familiar with REST, so this the backend do not have much involvement of AI
Check what Wordpress API or method can be used to handle REST request
Added genre to
Fix bugs in archive and single song template to display genre and songs
Created front-page.php, header.php and footer.php

---

### 3. Setup the plugin so it can be installed via Composer.

**Challenges and thinking process:**

1.  I know that npm allows users to upload their packages to the npm registry, is Composer similar to that?
2.  Any particular things I need to do before making it into a package?
3.  My project currently does not have Composer yet, how to initiate it to my current project?
4.  How to write composer.json in my project and in my package?
5.  Need to get familiar with Composer commands. What command to run to install the package for my project?
6.  My custom plugin is excluded by .gitignore, but other plugins are included, now I’m using Composer to maintain it. Should I add it to .gitignore?

**Questions to ask:**
The task’s requirement is quite clear, so no question to ask here.
Fixed an error of missing permissions to create REST endpoints

**Any reference?**

-   [How to Install Private Plugins and Themes with Composer and Github](https://www.youtube.com/watch?v=L892-Ql0guI)
    (step by step guildline)

    I have found a video on Youtube, which provides clear instructions of how to make your own package in Github and install it using Composer. Also, he teaches how to add tags like ‘1.0.1’ to my package so that I can specify the version of the package to be used. This was new to me. But the composer.json template from the video was missing a part called composer installer, which caused an error. Also it does not tell how to add Composer to a current project, I set up the environment using Chatgpt and updated the files like .gitignore, docker-compose.yml, .dockerignore.

**Any challenge?**
Not familiar with Composer’s command and files, I made some mistakes when taking templates from online tutorials.

**How are Chatgpt helped in this part?**

*   Fixed an issue of Composer file, missing installer
*   Asked Composer’s command to install, update, remove the plugin
*   I opened two branches for task 1 and task 2, but this were not quite necessary, a time when I switched between branches, I accidentally deleted some stashed changes and caused problem, the website not running properly, so I used AI to provide solution to recover

---

## Task 3 – Collaborative Design Approach
*Based on this page design, please outline:*
*— Any technical challenges you anticipate during build.*
*— Any UX, UI or accessibility issues you can identify.*
*— Any opportunities you see to make the build process more efficient.*
*— Your response is best provided as notes or markups design.*

The website design is modern and beautiful, but could potentially facing these challenges during build:

1.  The website needs to be able to adapt to different devices. I can see different sizes of images, make sure they can adapt to different sizes of screens and achieve the best effect (not some image too small, some too big, whether the navigator displays correctly, etc.)
2.  I see three carousel in the page, maybe we need to consider making them a reusable component, these carousel are similar, not exactly the same, so we need to think about a way how to design the component, we can also consider libraries or plugins that could help with building carousel
3.  May need to handle situation where map is not loading, async loading to achieve best performance
4.  Similar to maps, we need to handle ‘Book a session’ function not responding, not loading and async loading

In terms of UX, UI or accessibility, overall, this website has a good interface design by using block elements, the whole layout helps to present information clearly and structurally. There might be some potential issue though:

1.  Have our clients check the colour combinations? Does the information on the website meet their expectation?
2.  Also I can see that there are two same maps, which is not necessarily and complicating the website, and could potentially affect website’s load speed
3.  I am familiar with WCAG while in school, so I noticed that the navigator’s text colour is white or light grey, and its background is transparent, this could potentially have a contrast ratio issue against the WCAG 2.1 AA standards, people with visual impairments might find it hard to read, we can use tools like WAVE to do some testing. The hero section is the same.
4.  In term of convenience, I suggest making cards in ‘Our services’ section static, carousel might hide the website’s core offerings behind

There are some opportunities to help make the build process more efficiently:

1.  We could use reusable elements like cards, buttons, block layouts, etc. to make the site more maintainable and consistent
2.  We can use current template to build the frontend rather than building from zero, if the template is not from Wordpress, it can be using any frameworks, Vue or Next.js, then we can turn backend into a headless Wordpress, this accelerating development speed

---

## Reflection on tasks
### What can be improved

1.  UI is not my top priority so far, can be improved in the future by using interactive elements, block designs, template, etc.
2.  For simplicity, I have placed different functionalities into one single file,  Javascript code, shortcode, taxonomy, etc. They can be separate in the future for better readability and maintainability
3.  I have change the custom post type name to ‘song’, because ‘Songs’ from task requirement not meet the Wordpress Coding Standard, also, I can’t use ‘songs’ as well due to the same reason, but if needed, we can discuss these in the future
4.  For simplicity in this specific task, local database credentials are hardcoded in docker-composer.yml, this won’t happen in the future
5.  There are inline CSS in templates like front-page.php but can be moved out for improvement
6.  REST endpoint security can be further improved by limiting submission rate within specific time frame, and also by adding verification of human to prevent bots submitting the form

---

### Thank you for reading