
There is nothing worse than having to demonstrate a big, complex web project that didn't make it online. Anyways, here I go. Below is a quick synopsis of all of the coding and design work that went into Ovr. For more information please see the attached modules in the repos. For the sake of clarity and in some case to protect IP I have not included all modules, data, and code. If you have any question please feel free to get in contact. I am happy to sit down over a cup of coffee and explain the project in detail.

Ben 

# Visa Project Notes

Ovr was my first major web project. Before that, I had learned enough HTML, CSS, JavaScript, PHP and Drupal to hack together some insignificant little web projects, but nothing like this. 


## The Problem
Each year over 65 million business travellers, immigrants, and vacationers attempt to navigate the United State's horribly complex immigration system. There are over 85 different Visa Classes for the United States. Each Visa Classes has their own set of forms, legal requirements, and submission processes. On top of this the system is time consuming and can by very expensive.

 ## Big Idea
The Big Idea behind the site was to build a web platform that would help simplify the enormously complex US Immigration System. From that, Ovr was born.

## The Business
In late 2017, I formed a joint partnership with a law firm to develop the project. My role in the business was deliver the backend of the project. This included all of the planning and coding that went into the project. My business partners' role was to fiance the venture, hire a front end designer, and to add bring their legal expertise to the venture. Both parties would be joint responsible for business strategy, content generation and site planning.  

## MVP
Given the sheer number of visas involved, it was decided to start with the most basic visa class available, the B Visa. B Visas are the 'vanilla ice cream' of the US Immigration system. Each every over 10 million receive a B Visa for travel the United States, but nearly as many are refused. 

It was decided that the following two items would constitute the MVP.  
- A Visa Eligibility Checker that would pre-check an applicant's potential to get a B Visa for the United States. (My Idea)
- A way to submit the applicant information we gathered from the Visa Eligibility Checker to the US Government's [CEAC/DS-160](https://ceac.state.gov/genniv/) site. (My Partners' Idea) 

## Site Info
-| -    
:-------|:-----
Name   | Ovr LLC/LTD
URL    | https://go-ovr.com
CMS    | Drupal 8/PHP
Module | Lots of custom modules
Status | Inactive 


## The Build 
The first major decision was to decide which language/CMS to use for the build. Given the complexity of the site it would be impossible to hand code all of the site. A CMS would be needed. The two most logical CMS for something like this would be Django or Drupal. I was tempted to built it using Python/Django but at the time I had never worked with Django. This left Drupal 8. 

Before starting I had some experience with Drupal 7 and it worked great for my little personal blog. Plus by then Drupal 8 had been released and was stable. Plus given the size of the Drupal community and the sheer numbers of modules available, Drupal 8 won out.  

I admit that at this point I was a little naive. The OOP jump from Drupal 7 to Drupal 8 was much bigger than I expected. Also the size and scope of the project quickly grew exponentially.  

For the sake of clarity, I subdivided the The MVP down into the <b><u>B Visa Module</u></b> and the <b><u>B Visa Submission Module</u></b>.

## Site Roles 

Role Name | Role Machine Name | Permission 
----------|-------------------|------------
Admin | admin | site access
Anonymous | anonymous | published content
Authenticated | authenticated | published content
BVisa Subscriber| bvisa_subscriber | access bvisa content 
BVisa Submission Subscriber| bvisa_submission_subscriber | access bvisa subscriber content
EVisa Subscriber| evisa_subscriber | access evisa content 
EVisa Submission Subscriber| evisa_submission_subscriber | access evisa subscriber content 
***Visa Subscriber | ***visa_subscriber | a new role for each visa class
***Visa Submission Subscriber | ***visa_submission_subscriber | a new role for each visa submission class
 

## Routes/Paths associated with the BVisa and BVisa Submission Modules

To give a sense of the size of the project, here are just the routes/paths associated with the <b><u>B Visa Subscriber/Submission modules</u></b>


Page | Paths | Type | Notes
-----|------|------|------
B Visa Page| {language}/project/usa/b-visa| redirect| Redirects to B Visa Discovery Page
B Visa Discovery Page| {language}/project/usa/b-visa/discovery| page| Links to Ovr Page
B Visa User Page Redirect | {language}/project/usa/b-visa/user| redirect | Redirects to B Visa User Page
B Visa User Page | {language}/project/usa/b-visa/user/{username}|  controller/hook/route/twig| Returns Current User's name for a start
B Visa User Profile Page | {language}/project/usa/b-visa/user/{username}/profile | webform/page| Links to bvisa_user_profile Webform
B Visa How to Use Page | {language}/project/usa/b-visa/how-to-use| page| Links to Ovr Page
B Visa User Data Page | {language}/project/usa/b-visa/data| webform/page| Links to bvisa_user_data Webform
B Visa Questions Page| {language}/project/usa/b-visa/questions| Webform/page| Links to bvisa_questions Webform
B Visa Results Page | {language}/project/usa/b-visa/results| controller/hook/route/twig| Returns results from bvisa_questions Webform and marries results with BVisa Blackbox DBs and BVisa Res Opts
B Visa Feedback Page| {language}/project/usa/b-visa/feedback| webform/page| Links to bvisa_feedback Webform
B Visa Follow Up Page| {language}/project/usa/b-visa/follow-up| webform/page| Links to bvisa_follow_up Webform
B Visa More Informaton Page| {language}/project/usa/b-visa/more-information| page| Links to Ovr Page
B Visa Submit Now Page| {langague}/project/usa/b-visa/submit-now| controller/hook/route/twig| If User has paid, it will give them the link to the Python Bridge Script
B Visa Required Questions for DS-160| {language}/project/usa/b-visa/ds-160/required-questions| webform/page| Links to bvisa_required_questions

## Contributed Modules
One of Drupal's great strengths is its contributed modules . I used the following on the build. 
- Webform
- Commerce 
- Migrate Modules 

### Webform Module 
The Drupal Webform module was a godsend. The forms for the site ended up being huge. It was great to be able to use the Webform UI to build, manage, and update the webforms without manually updating the code. Also it was extremely helpful when it came to export the Webform Config into the production environment.  

### Commerce Module  
The Drupal Commerce was another extremely helpful module. The site was essentially a subscription site that sold permissions to its users. The Commerce module allowed me to integrate the whole payment processing system into site without the need to reinvent the payment processing wheel. 

### Migration Modules
The Migration Modules have advance some much over the last few years. They really help bridge that gap when it comes to migrating content from an old site or outside data source to a new Drupal 8 site. 
- Migrate Plus (migrate_plus) 
- Migrate Source CSV (migrate_source_csv)
- Migrate Tools (migrate_tools)          


## B Visa Module
The B Visa Module was the first half of the MVP. Below is some of the logic and code that went into building the module. 

### B Visa Module Work Flow.
Below is the work flow for the B Visa Module.
- An anonymous user (in the Drupal sense), would come to Ovr and be directed to the <b><u>B Visa Section</u></b>.
- On the <b><u>B Visa Discovery Page</u></b> they would find basic information in the B Visa Class and the services Ovr provides. 
- If they wanted to subscribe to Ovr's services they would be directed to the subscription page (built using the Drupal Commerce module). 
- Once their payment has cleared they would be granted 'Authenticated' and 'B Visa Subscription' user status.
- They would then be redirected to the <b><u>B Visa How to Use Page</u></b>.
- On the <b><u>B Visa How to Use Page</u></b> they would learn how to use the Visa Eligibility Checker. 
- They would then be directed to the <b><u>B Visa User Data Page</u></b>. Using a webform, the <b><u>B Visa User Data Page</u></b> would record the applicant's preferences to how their data is used and how long their data will be stored for. They would then be directed to the <b><u>B Visa Questions Page</u></b>.
- Using a very complex webform, <b><u>B Visa Questions Page</u></b> would ask the user roughly a hundred questions we felt was necessary in order ascertain if they would ultimately meet the visa eligiblity requirments for a B Visa. 
- For example, we would ask the user their nationaly. From government records we know that an applicant from Norway is far more like to be approved for a visa than a person from North Korea. 
- Once the applicant had finished the necessary question and their answers were submitted, they were directed to the <b><u>B Visa Results Page</u></b>.
- The <b><u>B Visa Results Page</u></b> is where the real magic happened. The controller for the page would get the applicant's request from their submission, take those answers and compare them against a series of custom database tables. Based on their inputs they would receive a score from 1 to 100 as to their likelihood of getting a B Visa.
- In addition to a Eligibility Score, they would also receive a custom response (Response Option content type) based on their responses. 
- For Example, a response option for a North Korean applicant would say that "Under current US government policy North Koreans are not eligible for a visa to the United States." 
- They would then be directed to the <b><u>B Visa Feedback Page</u></b> where they would be asked to provide feedback on the Eligibility Checker.

 
### B Visa Module Code Quick Run Down

Here is a quick run down of the B Visa Module Code. Here I have only included the highlights and stuff I am proud of. For the full code please see [B Visa Module](bvisa). 

### B Visa Module Info
```yml
name: 'BVisa'
type: module
description: 'The BVisa Module'
core: 8.x
```

### B Visa Module Routes

Route Example

[bvisa.routing.yml](bvia/bvisa.routing.ym)

```yml
bvisa.b_visa_controller_bvisa_discovery_page:
  path: 'projects/usa/b-visa/discovery'
  defaults:
    _controller: '\Drupal\bvisa\Controller\BVisaController::bvisa_discovery_page'
    _title: 'B Visa Discovery Page'
  requirements:
    _permission: 'access content'

```

### B Visa Controller

[B Visa Controller](bvisa/src/Controller/BVisaController.php)

The Controller for the B Visa Module contains most of the code for the project. There are undoubtedly many instances where I could/should have used the Drupal UI, but for my first project I found it immensely helpful to code it all out, that way I could dump() everything and see what was going on. 

Below this the bvisa_results_page() method for the B Visa Results Page. For the sake of clarity, I cut out all of the other custom database calls except for the one for Nationality.     

```php 

class BVisaController extends ControllerBase {

  /**
   * B Visa Results Page
   */

  public function bvisa_results_page() {

      // Checks to see if user has the correct "bvisa_subscriber" role assigned?
      // If not redirect USER to BVisa Questions Page  
      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }
        
      // Get bvisa_questions results for current user     
      $userCurrent = \Drupal::currentUser();
      $uid = $userCurrent->id();
      $query = \Drupal::entityQuery('webform_submission');
      $query->condition('webform_id', 'bvisa_questions');
      $query->condition('uid', $uid);
      $query->sort('completed', 'DESC');
      $query->range(0,1);
      $nids = $query->execute();
      $nid = key($nids);
      $webform_submission = webform\Entity\WebformSubmission::load($nid);
      $data = $webform_submission->getData();

      // Black Box Model for Nationality
      $nationality = $data['bvisa_questions_qid_0240'];
      $bvisa_demograpics_nationality = $nationality;
      $connection = \Drupal::database();
      $query = $connection->query("SELECT nationality, model_1 FROM {bvisa_blackbox_nationality} WHERE nationality = :nationality",
          [':nationality' => $bvisa_demograpics_nationality, ]);
      $result  = $query->fetchAssoc();
      $bvisa_blackbox_score_nationality_score = $result["model_1"];
      $bvisa_blackbox_score_nationality_value = $result["nationality"];
      $build['#blackbox']['nationality']['score'] = $bvisa_blackbox_score_nationality_score;
      $build['#blackbox']['nationality']['value'] = $bvisa_blackbox_score_nationality_value;

      //Black Box Total
      $bvisa_blackbox_total_score = 
        $bvisa_blackbox_score_age_score +   
        $bvisa_blackbox_score_education_score + 
        $bvisa_blackbox_score_employment_score +
        $bvisa_blackbox_score_nationality_score+
        $bvisa_blackbox_score_wages_score;

      $build['#blackbox']['total'] = $bvisa_blackbox_total_score;

      foreach ($data as $key => $value) {
          $query = \Drupal::entityQuery('node');
          $query->condition('type', 'res_opts');
          $query->condition('field_res_opts_form_name', 'bvisa_questions');
          $query->condition('field_res_opts_question_id', $key);
          $query->condition('field_res_opts_option', $value);
          $query->range(0, 1);
          $nids = $query->execute();

          if (key($nids) != NULL ) {

              $node = node_revision_load(key($nids));
              $title = $node->getTitle();
              $body = $node->get('body')->value;
              $res_opts_question = $node->get('field_res_opts_question')->value;
              $res_opts_option = $node->get('field_res_opts_option')->value;

              $build['#response_options'][$key] = [
                  'question' => [
                      '#markup' => $res_opts_question,
                  ],
                  'option' => [
                      '#markup' => $res_opts_option,
                  ],
                  'title' => [
                      '#markup' => $title,
                  ],
                  'body' => [
                      '#markup' => $body,
                  ],
                  'show' => true,
              ];
          }
          else
          {
              $build['#response_options'][$key]['question']['#markup'] = "NO RESPONSE OPTION FOUND FOR QUESTION ".$key;
              $build['#response_options'][$key]['option']['#markup'] = "NO RESPONSE OPTION FOUND FOR QUESTION ".$key;
              $build['#response_options'][$key]['title']['#markup'] = "NO RESPONSE OPTION FOUND FOR QUESTION ".$key;
              $build['#response_options'][$key]['body']['#markup'] = "NO RESPONSE OPTION FOUND FOR QUESTION ".$key;
              $build['#response_options'][$key]['show'] = false;
          }
      }

      $build['#theme'] = 'bvisa_results_page';
      $build['#test'] = 'Test Test Test';

      return $build;
  }
```

### B Visa Hook

Here is the hook for the B Visa Module. The code below passes the render array generated in the BVisaController to the custom bvisa_results_page TWIG. 

[bvisa.module](bvisa/bvisa.module)

```php

function bvisa_theme()
{
    return [
        'bvisa_results_page' => [
            'variables' => [
                'response_options' => NULL,
                'blackbox' => NULL,
            ],
        ],

    ];
}

```

## B Visa Results Page TWIG

Below is the custom TWIG/HTML used to render the B Visa Results Page. I used built a simple custom sub-theme that used the Bootstrap theme. This gave me access to the Bootstrap 3 CSS Library.

[B Visa Results Page TWIG](bvisa/templates/bvisa-results-page.html.twig)

```TWIG
{# Twig Template for BVisa Results Page #}

<h1>Black Box and Response Options Test Code</h1>

<div>
    <h2>Results from Black Box Age DB</h2>
    <h3>{{ blackbox.age.value }}</h3>
    <h3>{{ blackbox.age.score }}</h3>
</div>
<div>
    <h2>Results from Black Box Education DB</h2>
    <h3>{{ blackbox.education.value }}</h3>
    <h3>{{ blackbox.education.score }}</h3>
</div>
<div>
    <h2>Results from Black Box Employment DB</h2>
    <h3>{{ blackbox.employment.value }}</h3>
    <h3>{{ blackbox.employment.score }}</h3>
</div>
<div>
    <h2>Results from Black Box Nationality DB</h2>
    <h3>{{ blackbox.nationality.value }}</h3>
    <h3>{{ blackbox.nationality.score }}</h3>
</div>
<div>
    <h2>Results from Black Box Wages DB</h2>
    <h3>{{ blackbox.wages.value }}</h3>
    <h3>{{ blackbox.wages.score }}</h3>
</div>
<div>
    <h2>Total Score from Black Box DBs</h2>
    <h3>{{ blackbox.total }}</h3>
</div>


<ul>
    {% for r in response_options %}
        {% if r.show == true %}
            <div style=" border-radius: 10px; border: 10px solid slategrey; padding: 20px; margin-bottom: 10px">
                <h2>{{ r.question }}</h2>
                <h2>{{ r.option }}</h2>
                <p>{{ r.body }}</p>
            </div>
        {% endif %}
    {% endfor %}
</ul>

```

### B Visa Service

Here I add the UserCheck Service. This checked to make sure that the user had actually paid and was assigned the the "bvisa_subscriber" role before being allowed to access much of the B Visa Module. 

[UserCheck Service](bvisa/src/Services/UserCheck.php)


```php

/**
 * Class UserCheck
 */
 
class UserCheck {

    public function getUserCheck() {

        $userCurrent = \Drupal::currentUser();
        $user = User::load($userCurrent->id());
        $roles = $user->getRoles();

        if (in_array("bvisa_subscriber", $roles))
        {
            $user_check = TRUE;
        }
        elseif(in_array("staff_only", $roles))
        {
            $user_check = TRUE;
        }
        elseif (in_array("administrator", $roles))
        {
            $user_check = TRUE;
        }
        else
        {
            $user_check = FALSE;
        }
        return $user_check;
    }
}

```

### Webforms Needed

Due to the complexity of the project, lots of information was required from the applicant. I turned to the Webform module to build and manage the often complex Webforms need. In the first half of the MVP, no less than six webforms were required. These forms tracked everything from how the user would like their information stored in accordance with GDPR regulations, to a follow up form that was automatically sent once the applicant completed their interview for a visa. 

Webform Names | Machine Names
--------------|--------------
B Visa User Data Webform| bvisa_user_data
B Visa User Profile Webform| bvisa_user_profile
B Visa Questions Webform| bvisa_questions
B Visa User Feedback Webform| bvisa_user_feedback
B Visa User Followup Webform| bvisa_user_followup
B Visa Required Questions Webform| bvisa_required

### B Visa Questions
The largest and most complex of the webforms that was need was the bvisa_questions form. This form was well over 100 questions long and often required complex logic to produce a series of nested questions. Below is a small example of the export config file for the bvisa_questions webform.  

```TWIG
uuid: ee10d6ea-c0eb-47b4-b87d-f5c57de1b410
langcode: en
status: open
dependencies: {  }
open: null
close: null
weight: 0
uid: 1
template: false
archive: false
id: bvisa_questions
title: 'BVisa Questions'
description: 'BVisa Questions'
category: BVisa
elements: |
    bvisa_questions_qid_0010:
      '#type': select
      '#title': 'At which United States Embassy or Consulate will you be applying for your visa?'
      '#access': true
      '#options': project_usa_locations_to_apply
    bvisa_questions_qid_0230:
      '#type': select
      '#title': 'Applicants Country of Birth'
      '#access': true
      '#options': project_usa_countries_plus_mexico
    bvisa_questions_qid_0240:
      '#type': select
      '#title': 'Applicants Nationality'
      '#access': true
      '#options': project_usa_countries
      '#empty_option': 'I prefer not to say'
      '#empty_value': 'I prefer not to say'
    bvisa_questions_qid_0250:
      '#type': radios
      '#title': 'Applicant Other Nationality'
      '#access': true
      '#options':
        'yes': 'Yes'
        'no': 'No'
        unsure: Unsure
        'i prefer not to say': 'I prefer not to say'
    bvisa_questions_qid_0840:
      '#type': select
      '#title': 'Purpose of Trip'
      '#access': true
      '#options':
        '': 'PLEASE SELECT A VISA CLASS'
        A: 'FOREIGN GOVERNMENT OFFICIAL (A)'
        B: 'TEMP. BUSINESS PLEASURE VISITOR (B)'
        C: 'ALIEN IN TRANSIT (C)'
        CNMI: 'CNMI WORKER OR INVESTOR (CW/E2C)'
        D: 'CREWMEMBER (D)'
        E: 'TREATY TRADER OR INVESTOR (E)'
        F: 'ACADEMIC OR LANGUAGE STUDENT (F)'
        G: 'INTERNATIONAL ORGANIZATION REP./EMP. (G)'
        H: 'TEMPORARY WORKER (H)'
        I: 'FOREIGN MEDIA REPRESENTATIVE (I)'
        J: 'EXCHANGE VISITOR (J)'
        K: 'FIANCE(E) OR SPOUSE OF A U.S. CITIZEN (K)'
        L: 'INTRACOMPANY TRANSFEREE (L)'
        M: 'VOCATIONAL/NONACADEMIC STUDENT (M)'
        'N': 'OTHER (N)'
        NATO: 'NATO STAFF (NATO)'
        O: 'ALIEN WITH EXTRAORDINARY ABILITY (O)'
        P: 'INTERNATIONALLY RECOGNIZED ALIEN (P)'
        PAROLE-BEN: 'PAROLE BENEFICIARY (PARCIS)'
        Q: 'CULTURAL EXCHANGE VISITOR (Q)'
        R: 'RELIGIOUS WORKER (R)'
        S: 'INFORMANT OR WITNESS (S)'
        T: 'VICTIM OF TRAFFICKING (T)'
        TD/TN: 'NAFTA PROFESSIONAL (TD/TN)'
        U: 'VICTIM OF CRIMINAL ACTIVITY (U)'
```


### Response Options
The B Visa Module makes use of a custom content type called Response Options. I built the Response Options using the UI and then exported it using the config file to the production environment. 
 
 In essence each Response Option was a response to the answers given by the applicants on the bvisa_questions webform. For example, if an applicant from North Korea selected North Korean as their nationality, a Response Option would show a text block with a warning stating that they might 'have trouble getting a visa for the United States.'  
 
 Given the 100+ questions found on the bvisa_questions webform and many different possible answers an applicant could give (for example there are over 250 different nationalities alone in the world) the number of possible Response Options needed quickly exploded. It was impossible (not to mention horribly tedious) to use the Drupal 8 UI to create each custom Response Option node, so I turned to Drupal's content migration system. 

### RESPONSE OPTIONS MIGRATION

Outside of Drupal, using Excel and Python I cobbled together the several thousand various Response Options into a convenient to use CSV file. From there using the Migrate Plus, Migrate Tools, and Migrate Source CSV Modules to import the CSV data in to the Response Options content type.

[B Visa Response Options](bvisa_res_opts_migration\migrations\bvisa_res_opts_migration.yml)

```YML
id: bvisa_res_opts_migration
label: Import BVisa Response Options
migration_groups:
    - Response_Options import

source:
    plugin: csv
    path: 'modules/custom/ovr/bvisa_res_opts_migration/assets/csv/bvisa_res_opts_migration_text.csv'
    delimiter: ','
    enclosure: '"'
    header_row_count: 1
    keys:
        - ID
    column_names:
        0:
            ID: "unique id"
        1:
            title: "title"
        2:
            body: "response option text"
        3:
            field_res_opts_projects: "project"
        4:
            field_res_opts_form_name: "name of webform"
        5:
            field_res_opts_language: "language"
        6:
            field_res_opts_question: "question"
        7:
            field_res_opts_question_id: "question id"
        8:
            field_res_opts_option: "option"
        9:
            field_res_opts_option_hide: "hide"
        10:
            field_res_opts_option_flag: "flag"
        11:
            field_res_opts_option_priority: "priority"
        12:
            field_res_opts_option_status: "status"
        13:
            field_res_opts_question_section1: "section one"
        14:
            field_res_opts_question_section2: "section two"
        15:
            field_res_opts_order: "order of response options"

process:
    title: title
    body: body
    field_res_opts_projects: field_res_opts_projects
    field_res_opts_form_name: field_res_opts_form_name
    field_res_opts_language: field_res_opts_language
    field_res_opts_question: field_res_opts_question
    field_res_opts_question_id: field_res_opts_question_id
    field_res_opts_option: field_res_opts_option
    field_res_opts_option_hide: field_res_opts_option_hide
    field_res_opts_option_flag: field_res_opts_option_flag
    field_res_opts_option_priority: field_res_opts_option_priority
    field_res_opts_option_status: field_res_opts_option_status
    field_res_opts_question_section1: field_res_opts_question_section1
    field_res_opts_question_section2: field_res_opts_question_section2
    field_res_opts_order: field_res_opts_order
    type:
        plugin: default_value
        default_value: res_opts

destination:
    plugin: entity:node


```

## B Visa Submission Module

Unfortunately this is where it all fell apart. My business partners were eager to find a way to automatically submit the user data we collected in the first half of the MVP (B Visa Module) to the US Government's [CEAC/DS-160](https://ceac.state.gov/genniv/) site, but this was no easy task.

1. The US Government has no API for immigration visas. 
2. The US Government is deeply paranoid when it comes to their computer systems. The form is Captcha/Password protected and is littered with honeypot traps throughout. 
3. The form is horrible complex. As far as I can tell, there are at least 357 questions for the simple, vanilla, B Visa alone.

Initially I tried using Javascript, but the problems with cross-scripting quickly ruled that out. I then hit upon the use of [Selenium](https://www.seleniumhq.org/) to build a web browser that could automate the delivery of the user data collected to the government site. First I tried to use the PHP [Behat](http://behat.org) library to integrate the web browser into my existing Drupal/PHP build, but I couldn't get it to work. 

I then turned to Python. Using Flask I was able to build a local test app that was able to take user input information from the Drupal Webform on one site and input it on a third party site. Needless to say I was very excited. 

### The End
Unfortunately before I was able to go any further my business partner's funding fell through and the project was shelved. This was horribly disappointing, but looking back on the project I am proud of the complex work that I have accomplished work on my own. Given a chance, I will make an excellent addition to your web development team.

RBP 