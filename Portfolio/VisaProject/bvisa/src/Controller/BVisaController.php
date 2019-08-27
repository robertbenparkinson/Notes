<?php

namespace Drupal\bvisa\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\webform;


/**
 * Class BVisaController.
 */

class BVisaController extends ControllerBase {

  /**
   * B Visa Page
   */

  public function bvisa_page() {

    $redirectURL = 'projects/usa/b-visa/discovery';
    return new RedirectResponse(base_path().$redirectURL);
  }


  /**
   * B Visa Discovery Page
   */

  public function bvisa_discovery_page() {

    $value = 'bvisa_discovery_page';

    $query = \Drupal::entityQuery('node');
    $query->condition('type', 'ovr_pages');
    $query->condition('field_ovr_pages_page_id', $value);
    $nid = $query->execute();

    $node = Node::load($nid[key($nid)]);

//    dump($node);

    $title = $node->get('title')->value;
    $body = $node->get('body')->value;

//    dump($body);

    $build = [
      '#theme' => 'bvisa_discovery_page',
      '#title' => $title,
      '#body' => [
          '#type' => 'markup',
          '#markup' => $body,
          ],
      ];


//    $build = [
//      '#theme' => 'bvisa_discovery_page',
//      '#title' => $title,
//      '#body' => $body,
//    ];

//    $build = [
//      '#theme' => 'bvisa_discovery_page',
//      '#title' => $title,
//      '#type' => 'markup',
//          '#marktup' => $body,
//          ],
//      ];

    return $build;
  }


  /**
   * B Visa User Page
   */

  public function bvisa_user_page() {

    $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();


    if($user_check==FALSE)
    {
        $redirectURL = 'projects/usa/b-visa/discovery';
        return new RedirectResponse(base_path().$redirectURL);
    }


    $userCurrent = \Drupal::currentUser();
    $user = User::load($userCurrent->id());

    $username = $user->getUsername();

    $username = str_replace(" ", "-", $username);
    $username = strtolower($username);

    $redirectURL = 'projects/usa/b-visa/user/'.$username;
    return new RedirectResponse(base_path().$redirectURL);

  }

    /**
     * B Visa User Username Page
     */


    public function bvisa_user_username_page($username) {

        $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

        if($user_check==FALSE)
        {
            $redirectURL = 'projects/usa/b-visa/discovery';
            return new RedirectResponse(base_path().$redirectURL);
        }

        $userCurrent = \Drupal::currentUser();
        $user = User::load($userCurrent->id());
        $username = $user->getUsername();

        $email = $user->getEmail();

        //Get the current user's ID
        $uid = $user->id();

        $build['#theme'] = 'bvisa_user_username_page';
        $build['#username'] = $username;
        $build['#email'] = $email;


        // USER PROFILE CHECK
        // Check to see if the USER has submitted the USER PROFILE webform

        $query = \Drupal::entityQuery('webform_submission');
        $query->condition('webform_id', 'bvisa_user_profile');
        $query->condition('uid', $uid);
        $query->sort('completed', 'DESC');
        $query->range(0,1);
        $nids = $query->execute();

        $nid = key($nids);

        if (is_int($nid)){
            $bvisa_user_profile_webform_status_text = "The Follow Up Form for the B Visa have been submitted";
        }
        else {
            $bvisa_user_profile_webform_status_text = "The Follow Up Form  for the B Visa have not been submitted";
            $bvisa_user_profile_webform_status_link = base_path().'projects/usa/b-visa/user/'.$username.'/profile';;

//            var_dump($bvisa_user_profile_webform_status_link);

            $build['#bvisa_user_profile_webform_status_link'] = $bvisa_user_profile_webform_status_link;
        }


        // USER DATA CHECK
        // Check to see if the USER has submitted the DATA webform

        $query = \Drupal::entityQuery('webform_submission');
        $query->condition('webform_id', 'bvisa_user_data');
        $query->condition('uid', $uid);
        $query->sort('completed', 'DESC');
        $query->range(0,1);
        $nids = $query->execute();

        $nid = key($nids);

        if (is_int($nid)){
            $bvisa_user_data_webform_status_text = "The B Visa Data Form questions has been submitted";
        }
        else {
            $bvisa_user_data_webform_status_text = "The B Visa Data Form questions has not been submitted";
            $bvisa_user_data_webform_status_link = base_path().'projects/usa/b-visa/user/'.$username.'/data';

            $build['#bvisa_user_data_webform_status_link'] = $bvisa_user_data_webform_status_link;
        }


        // QUESTIONS CHECK
        // Check to see if the USER has submitted the QUESTIONS webform

        $query = \Drupal::entityQuery('webform_submission');
        $query->condition('webform_id', 'bvisa_questions');
        $query->condition('uid', $uid);
        $query->sort('completed', 'DESC');
        $query->range(0,1);
        $nids = $query->execute();

        $nid = key($nids);

        if (is_int($nid)){
            $bvisa_questions_webform_status_text = "The Questions Form for the B Visa has been submitted";
        }
        else {
            $bvisa_questions_webform_status_text = "The Questions Form for the B Visa has not been submitted";
            $bvisa_questions_webform_status_link = base_path().'projects/usa/b-visa/questions';

            $build['#bvisa_questions_webform_status_link'] = $bvisa_questions_webform_status_link;
        }


        // Required DS-160 Questions CHECK
        // Check to see if the USER has submitted the bvisa_required webform

        $query = \Drupal::entityQuery('webform_submission');
        $query->condition('webform_id', 'bvisa_required');
        $query->condition('uid', $uid);
        $query->sort('completed', 'DESC');
        $query->range(0,1);
        $nids = $query->execute();

        $nid = key($nids);

        if (is_int($nid)){
            $bvisa_required_webform_status_text = "The Follow Up for the B Visa have been submitted";
        }
        else {
            $bvisa_required_webform_status_text = "The Follow Up for the B Visa have not been submitted";
            $bvisa_required_webform_status_link = base_path().'projects/usa/b-visa/questions';

            $build['#bvisa_required_webform_status_link'] = $bvisa_required_webform_status_link;
        }


        // FEEDBACK CHECK
        // Check to see if the USER has submitted the FEEDBACK webform

        $query = \Drupal::entityQuery('webform_submission');
        $query->condition('webform_id', 'bvisa_user_feedback');
        $query->condition('uid', $uid);
        $query->sort('completed', 'DESC');
        $query->range(0,1);
        $nids = $query->execute();

        $nid = key($nids);

        if (is_int($nid)){
            $bvisa_user_feedback_webform_status_text = "The Feedback Form for the B Visa has been submitted";
        }
        else {
            $bvisa_user_feedback_webform_status_text = "The Feedback Form for the B Visa has not been submitted";
            $bvisa_user_feedback_webform_status_link = base_path().'projects/usa/b-visa/feedback';

            $build['#bvisa_user_feedback_webform_status_link'] = $bvisa_user_feedback_webform_status_link;

        }


        // FOLLOW UP CHECK
        // Check to see if the USER has submitted the FOLLOW UP webform

        $query = \Drupal::entityQuery('webform_submission');
        $query->condition('webform_id', 'bvisa_user_followup');
        $query->condition('uid', $uid);
        $query->sort('completed', 'DESC');
        $query->range(0,1);
        $nids = $query->execute();

        $nid = key($nids);

        if (is_int($nid)){
            $bvisa_user_followup_webform_status_text = "The Follow Up Form for the B Visa has been submitted";
        }
        else {
            $bvisa_user_followup_webform_status_text = "The Follow Up Form for the B Visa has not been submitted";
            $bvisa_user_followup_webform_status_link = base_path().'projects/usa/b-visa/follow-up';

            $build['#bvisa_user_followup_webform_status_link'] = $bvisa_user_followup_webform_status_link;

        }


//        Link to user/profile form

//        dump($build);

//        $build = [
//            '#theme'=> 'bvisa_user_username_page',
//            '#username' => $username,
//            '#email' => $email,
//            '#bvisa_user_data_webform_status_text' => $bvisa_user_data_webform_status_text,
//            '#bvisa_user_profile_webform_status_text' => $bvisa_user_profile_webform_status_text,
//            '#bvisa_questions_webform_status_text' => $bvisa_questions_webform_status_text,
//            '#bvisa_user_feedback_webform_status_text' => $bvisa_user_feedback_webform_status_text,
//            '#bvisa_user_followup_webform_status_text' => $bvisa_user_followup_webform_status_text,
//            '#bvisa_required_webform_status_text' => $bvisa_required_webform_status_text,
//            '#bvisa_user_followup_webform_status_link' => $bvisa_user_followup_webform_status_link,
//        ];



        $build['#bvisa_user_data_webform_status_text'] = $bvisa_user_data_webform_status_text;
        $build['#bvisa_user_profile_webform_status_text'] = $bvisa_user_profile_webform_status_text;
        $build['#bvisa_questions_webform_status_text'] = $bvisa_questions_webform_status_text;
        $build['#bvisa_user_feedback_webform_status_text'] = $bvisa_user_feedback_webform_status_text;
        $build['#bvisa_user_followup_webform_status_text'] = $bvisa_user_followup_webform_status_text;
        $build['#bvisa_required_webform_status_text'] = $bvisa_required_webform_status_text;



//        dump($build);

        return $build;

    }

    /**
     * B Visa User Profile Input form
     */

  public function bvisa_user_username_profile_page($username) {

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }

      $my_webform_machinename = 'bvisa_user_profile';
      $my_form = \Drupal\webform\Entity\Webform::load($my_webform_machinename);

      $build = [
          '#type' => 'webform',
          '#webform' => $my_form,
      ];

      return $build;

  }


  /**
   * B Visa How to Use Page
   */

  public function bvisa_how_to_use_page() {

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }


      $value = "bvisa_how_to_use_page";

      $query = \Drupal::entityQuery('node');
      $query->condition('type', 'ovr_pages');
      $query->condition('field_ovr_pages_page_id', $value);
      $nid = $query->execute();

      $node = Node::load($nid[key($nid)]);

      $title = $node->get('title')->value;
      $body = $node->get('body')->value;

      $build = [
          '#theme' => 'bvisa_how_to_use_page',
          '#title' => $title,
          '#body' => [
              '#type' => 'markup',
              '#markup' => $body,
          ],
      ];

      return $build;

  }


  /**
   * B Visa User Data Page
   */

  public function bvisa_user_data_page($username) {


      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }

      $my_webform_machinename = 'bvisa_user_data';
      $my_form = \Drupal\webform\Entity\Webform::load($my_webform_machinename);

      $build = [
          '#type' => 'webform',
          '#webform' => $my_form,
      ];

      return $build;

  }


  /**
   * B Visa Questions Page
   */

  public function bvisa_questions_page() {

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }


      $my_webform_machinename = 'bvisa_questions';
      $my_form = \Drupal\webform\Entity\Webform::load($my_webform_machinename);

      $build = [
          '#type' => 'webform',
          '#webform' => $my_form,
      ];

      return $build;

  }


  /**
   * B Visa Results Page
   */

  public function bvisa_results_page() {

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      // Possibly move to service

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }

      // Has the USER submitted a Questions Webform?
      // If not redirect USER to BVisa Questions Page

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



//      dump($data['question_0050']);



      // Black Box Model for Age
//      $bvisa_demograpics_age = '35 to 44';
      $age = $data['bvisa_questions_qid_0170'];

      $x = getdate();
      $date1 = date_create($x["year"].'-'.$x["mon"].'-'.$x["mday"]);
      $date2 = date_create(substr($age, 0,10));
      $diff = date_diff($date1, $date2);
      $year = $diff->y;

//      var_dump($year);

      if($year < 18) {
          $bvisa_demograpics_age = 'under 18';
      }
       elseif ($year >= 18 and $year > 25 ){
           $bvisa_demograpics_age = '18 to 24';
       }
       elseif ($year >= 25 and $year > 34){
           $bvisa_demograpics_age = '25 to 34';
       }
      elseif ($year >= 35 and $year > 44){
          $bvisa_demograpics_age = '35 to 44';
      }
      elseif ($year >= 45 and $year > 54){
          $bvisa_demograpics_age = '45 to 54';
      }
      elseif ($year >= 55 and $year > 64){
          $bvisa_demograpics_age = '55 to 64';
      }
      elseif ($year >= 65 and $year > 74){
          $bvisa_demograpics_age = '65 to 74';
      }
      elseif ($year >= 75 ){
          $bvisa_demograpics_age = '75 or more';
      }
      else{
          $bvisa_demograpics_age = 'i prefer not to say';
      }

//      var_dump($bvisa_demograpics_age);


      $connection = \Drupal::database();
      $query = $connection->query("SELECT age, model_1 FROM {bvisa_blackbox_age} WHERE age = :age",
          [':age' => $bvisa_demograpics_age, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_age_score = $result["model_1"];
      $bvisa_blackbox_score_age_value = $result["age"];

      $build['#blackbox']['age']['score'] = $bvisa_blackbox_score_age_score;
      $build['#blackbox']['age']['value'] = $bvisa_blackbox_score_age_value;
      // Black Box Model for Education
//      $education = $data['question_0050'];


//      var_dump($data['bvisa_questions_qid_2580']);
//      var_dump($data['bvisa_questions_qid_5000']);

      if ($data['bvisa_questions_qid_2580'] != "yes"){
          $bvisa_demograpics_education = 'no diploma';
      }
      else{

          if($data['bvisa_questions_qid_5000'] == 'no diploma'){
              $bvisa_demograpics_education = 'no diploma';
          }
          elseif ($data['bvisa_questions_qid_5000'] == 'high school/secondary diploma'){
              $bvisa_demograpics_education = 'high school/secondary diploma';
          }
          elseif ($data['bvisa_questions_qid_5000'] == 'technical qualification'){
              $bvisa_demograpics_education = 'technical qualification';
          }
          elseif ($data['bvisa_questions_qid_5000'] == 'bachelors degree'){
              $bvisa_demograpics_education = 'bachelors degree';
          }
          elseif ($data['bvisa_questions_qid_5000'] == 'masters degree'){
              $bvisa_demograpics_education = 'masters degree';
          }
          elseif ($data['bvisa_questions_qid_5000'] == 'professional degree'){
              $bvisa_demograpics_education = 'professional degree';
          }
          elseif ($data['bvisa_questions_qid_5000'] == 'doctorate degree' ){
              $bvisa_demograpics_education = 'doctorate degree';
          }
          elseif ($data['bvisa_questions_qid_5000'] == 'other' ){
              $bvisa_demograpics_education = 'other';
          }
          else{
              $bvisa_demograpics_education = 'i prefer not to say';
          }


      }


//      var_dump($bvisa_demograpics_education);




      $connection = \Drupal::database();
      $query = $connection->query("SELECT education, model_1 FROM {bvisa_blackbox_education} WHERE education = :education",
          [':education' => $bvisa_demograpics_education, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_education_score = $result["model_1"];
      $bvisa_blackbox_score_education_value = $result["education"];

//      var_dump($bvisa_blackbox_score_education_score);
//      var_dump($bvisa_blackbox_score_education_value);


      $build['#blackbox']['education']['score'] = $bvisa_blackbox_score_education_score;
      $build['#blackbox']['education']['value'] = $bvisa_blackbox_score_education_value;


      // Black Box Model for Employment
      $employment = $data['bvisa_questions_qid_5010'];
      $employment = strtolower($employment);

//      $bvisa_demograpics_employment = 'other';

      if($employment == 'full time employment'){
          $bvisa_demograpics_employment = 'full time employment';
      }
      elseif ($employment == 'self employed') {
          $bvisa_demograpics_employment = 'self employed';
      }
      elseif ($employment == 'part time employment') {
          $bvisa_demograpics_employment = 'part time employment';
      }
      elseif ($employment == 'stay at home parent') {
          $bvisa_demograpics_employment = 'stay at home parent';
      }
      elseif ($employment == 'not in work by choice') {
          $bvisa_demograpics_employment = 'not in work by choice';
      }
      elseif ($employment == 'student') {
          $bvisa_demograpics_employment = 'student';
      }
      elseif ($employment == 'unemployed') {
          $bvisa_demograpics_employment = 'unemployed';
      }
      elseif ($employment == 'retired from full time employment') {
          $bvisa_demograpics_employment = 'retired from full time employment';
      }
      elseif ($employment ==  'other') {
          $bvisa_demograpics_employment = 'other';
      }
      else{
          $bvisa_demograpics_employment = 'i prefer not to say';
      }

//    var_dump($bvisa_demograpics_employment);


      $connection = \Drupal::database();
      $query = $connection->query("SELECT employment, model_1 FROM {bvisa_blackbox_employment} WHERE employment = :employment",
          [':employment' => $bvisa_demograpics_employment, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_employment_value = $result["employment"];
      $bvisa_blackbox_score_employment_score = $result["model_1"];

      $build['#blackbox']['employment']['score'] = $bvisa_blackbox_score_employment_score;
      $build['#blackbox']['employment']['value'] = $bvisa_blackbox_score_employment_value;



      // Black Box Model for Ethnicity
      $ethnicity = $data['bvisa_questions_qid_5020'];
      $ethnicity = strtolower($ethnicity);
//      $bvisa_demograpics_ethnicity = 'caucasian';

//      var_dump($ethnicity);


      if ($ethnicity == 'african'){
          $bvisa_demograpics_ethnicity = 'african';
      }
      elseif ($ethnicity == 'caribbean'){
          $bvisa_demograpics_ethnicity = 'caribbean';
      }
      elseif ($ethnicity == 'caucasian'){
          $bvisa_demograpics_ethnicity = 'caucasian';
      }
      elseif ($ethnicity == 'east asian'){
          $bvisa_demograpics_ethnicity = 'east asian';
      }
      elseif ($ethnicity == 'latino/hispanic'){
          $bvisa_demograpics_ethnicity = 'latino/hispanic';
      }
      elseif ($ethnicity == 'middle eastern'){
          $bvisa_demograpics_ethnicity = 'middle eastern';
      }
      elseif ($ethnicity == 'mixed'){
          $bvisa_demograpics_ethnicity = 'mixed';
      }
      elseif ($ethnicity == 'other'){
          $bvisa_demograpics_ethnicity = 'other';
      }
      elseif ($ethnicity == 'south asian'){
          $bvisa_demograpics_ethnicity = 'south asian';
      }
      else{
          $bvisa_demograpics_ethnicity = 'i prefer not to say';
      }

//      var_dump($bvisa_demograpics_ethnicity);

      $connection = \Drupal::database();
      $query = $connection->query("SELECT ethnicity, model_1 FROM {bvisa_blackbox_ethnicity} WHERE ethnicity = :ethnicity",
          [':ethnicity' => $bvisa_demograpics_ethnicity, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_ethnicity_score = $result["model_1"];
      $bvisa_blackbox_score_ethnicity_value = $result["ethnicity"];

      $build['#blackbox']['ethnicity']['score'] = $bvisa_blackbox_score_ethnicity_score;
      $build['#blackbox']['ethnicity']['value'] = $bvisa_blackbox_score_ethnicity_value;

      // Black Box Model for Family
      $family = $data['bvisa_questions_qid_0160'];
      $kids = $data['bvisa_questions_qid_5060'];

        if ($kids == "yes") {
            $kids = ", With Children";
        }
        else{
            $kids = ", Without Children";
        }

//        var_dump($family);
//        var_dump($kids);


        if($family == "I prefer not to say"){
            $bvisa_demograpics_family = 'I prefer not to say';
        }
        elseif($family == 'Civil Union/Domestic Partnership'){
            $bvisa_demograpics_family = $family.$kids;
        }
        elseif($family == 'Common Law Marriage'){
            $bvisa_demograpics_family = $family.$kids;
        }
        elseif($family == 'Divorced'){
            $bvisa_demograpics_family = $family.$kids;
        }
        elseif($family == 'Legally Separated'){
            $bvisa_demograpics_family = $family.$kids;
        }
        elseif($family == 'Married'){
            $bvisa_demograpics_family = $family.$kids;
        }
        elseif($family == 'Other'){
            $bvisa_demograpics_family = $family.$kids;
        }
        elseif($family == 'Single'){
            $bvisa_demograpics_family = $family.$kids;
        }
        elseif($family == 'Widowed'){
            $bvisa_demograpics_family = $family.$kids;
        }

//        var_dump($bvisa_demograpics_family);



      $connection = \Drupal::database();
      $query = $connection->query("SELECT family, model_1 FROM {bvisa_blackbox_family} WHERE family = :family",
          [':family' => $bvisa_demograpics_family, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_family_score = $result["model_1"];
      $bvisa_blackbox_score_family_value = $result["family"];

      $build['#blackbox']['family']['score'] = $bvisa_blackbox_score_family_score;
      $build['#blackbox']['family']['value'] = $bvisa_blackbox_score_family_value;

      // Black Box Model for Nationality
      $nationality = $data['bvisa_questions_qid_0240'];
//      $nationality = strtolower($nationality);
      $bvisa_demograpics_nationality = $nationality;

//      dump($data);

      $connection = \Drupal::database();
      $query = $connection->query("SELECT nationality, model_1 FROM {bvisa_blackbox_nationality} WHERE nationality = :nationality",
          [':nationality' => $bvisa_demograpics_nationality, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_nationality_score = $result["model_1"];
      $bvisa_blackbox_score_nationality_value = $result["nationality"];

      $build['#blackbox']['nationality']['score'] = $bvisa_blackbox_score_nationality_score;
      $build['#blackbox']['nationality']['value'] = $bvisa_blackbox_score_nationality_value;

      // Black Box Model for Religion
      $religion = $data['bvisa_questions_qid_5030'];
      $religion = strtolower($religion);

//      $bvisa_demograpics_religion = 'taoist';


      if ($religion == 'agnostic'){
          $bvisa_demograpics_religion = 'agnostic';
      }
      elseif ($religion == 'atheist'){
          $bvisa_demograpics_religion = 'atheist';
      }
      elseif ($religion == 'bahai'){
          $bvisa_demograpics_religion = 'bahai';
      }
      elseif ($religion == 'buddhist'){
          $bvisa_demograpics_religion = 'buddhist';
      }
      elseif ($religion == 'christian'){
          $bvisa_demograpics_religion = 'christian';
      }
      elseif ($religion == 'confucian'){
          $bvisa_demograpics_religion = 'confucian';
      }
      elseif ($religion == 'fsm'){
          $bvisa_demograpics_religion = 'fsm';
      }
      elseif ($religion == 'hindu'){
          $bvisa_demograpics_religion = 'hindu';
      }
      elseif ($religion == 'jedi'){
          $bvisa_demograpics_religion = 'jedi';
      }
      elseif ($religion == 'jewish'){
          $bvisa_demograpics_religion = 'jewish';
      }
      elseif ($religion == 'mormon'){
          $bvisa_demograpics_religion = 'mormon';
      }
      elseif ($religion == 'muslim'){
          $bvisa_demograpics_religion = 'muslim';
      }
      elseif ($religion == 'scientologist'){
          $bvisa_demograpics_religion = 'scientologist';
      }
      elseif ($religion == 'sikh'){
          $bvisa_demograpics_religion = 'sikh';
      }
      elseif ($religion == 'taoist'){
          $bvisa_demograpics_religion = 'taoist';
      }
      elseif ($religion == 'traditional folk religions'){
          $bvisa_demograpics_religion = 'traditional folk religions';
      }
      elseif ($religion == 'none'){
          $bvisa_demograpics_religion = 'none';
      }
      elseif ($religion == 'other'){
          $bvisa_demograpics_religion = 'other';
      }
      else{
          $bvisa_demograpics_religion = 'i prefer not to say';
      }


      $connection = \Drupal::database();
      $query = $connection->query("SELECT religion, model_1 FROM {bvisa_blackbox_religion} WHERE religion = :religion",
          [':religion' => $bvisa_demograpics_religion, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_religion_score = $result["model_1"];
      $bvisa_blackbox_score_religion_value = $result["religion"];

      $build['#blackbox']['religion']['score'] = $bvisa_blackbox_score_religion_score;
      $build['#blackbox']['religion']['value'] = $bvisa_blackbox_score_religion_value;

      // Black Box Model for Sex
      $bvisa_demograpics_sex = $data['bvisa_questions_qid_0150'];
//      $bvisa_demograpics_sex = 'male';

      $bvisa_demograpics_sex = strtolower($bvisa_demograpics_sex);

//      var_dump($bvisa_demograpics_sex);

      $connection = \Drupal::database();
      $query = $connection->query("SELECT sex, model_1 FROM {bvisa_blackbox_sex} WHERE sex = :sex",
          [':sex' => $bvisa_demograpics_sex, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_sex_score = $result["model_1"];
      $bvisa_blackbox_score_sex_value = $result["sex"];

      $build['#blackbox']['sex']['score'] = $bvisa_blackbox_score_sex_score;
      $build['#blackbox']['sex']['value'] = $bvisa_blackbox_score_sex_value;


      // Black Box Model for Sexuality
      $sexuality = $data['bvisa_questions_qid_5040'];
      $sexuality = strtolower($sexuality);
//      $bvisa_demograpics_sexuality = 'heterosexual';

      if ($sexuality == 'heterosexual'){
          $bvisa_demograpics_sexuality = 'heterosexual';
      }
      elseif ($sexuality == 'homosexual'){
          $bvisa_demograpics_sexuality = 'homosexual';
      }
      elseif ($sexuality == 'bisexual'){
          $bvisa_demograpics_sexuality = 'bisexual';
      }
      elseif ($sexuality == 'asexual'){
          $bvisa_demograpics_sexuality = 'asexual';
      }
      elseif ($sexuality == 'pansexual'){
          $bvisa_demograpics_sexuality = 'pansexual';
      }
      elseif ($sexuality == 'other'){
          $bvisa_demograpics_sexuality ='other';
      }
      elseif ($sexuality == 'fabulous'){
          $bvisa_demograpics_sexuality ='fabulous';
      }
      else{
          $bvisa_demograpics_sexuality = 'i prefer not to say';
      }


      $connection = \Drupal::database();
      $query = $connection->query("SELECT sexuality, model_1 FROM {bvisa_blackbox_sexuality} WHERE sexuality = :sexuality",
          [':sexuality' => $bvisa_demograpics_sexuality, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_sexuality_score = $result["model_1"];
      $bvisa_blackbox_score_sexuality_value = $result["sexuality"];

      $build['#blackbox']['sexuality']['score'] = $bvisa_blackbox_score_sexuality_score;
      $build['#blackbox']['sexuality']['value'] = $bvisa_blackbox_score_sexuality_value;

      // Black Box Model for Wages
      $wages = $data['bvisa_questions_qid_2300'];
//      $bvisa_demograpics_wages = '$0 to $19,999 per year';

//      var_dump($wages);

      if (!is_numeric($wages)){
          $bvisa_demograpics_wages = 'I prefer not to say';
      }
      else {

          $wages = $wages * 12;

//          var_dump($wages);

          if ($wages < 20000) {
              $bvisa_demograpics_wages = '$0 to $19,999 per year';
          } elseif ($wages >= 20000 and $wages < 40000) {
              $bvisa_demograpics_wages = '$20,000 to $39,999 per year';
          } elseif ($wages >= 40000 and $wages < 60000) {
              $bvisa_demograpics_wages = '$40,000 to $59,999 per year';
          } elseif ($wages >= 60000 and $wages < 80000) {
              $bvisa_demograpics_wages = '$60,000 to $79,999 per year';
          } elseif ($wages >= 80000 and $wages < 100000) {
              $bvisa_demograpics_wages = '$80,000 to $99,999 per year';
          } elseif ($wages >= 100000) {
              $bvisa_demograpics_wages = '$100,000+ per year';
          }

      }

//    var_dump($bvisa_demograpics_wages);



      $connection = \Drupal::database();
      $query = $connection->query("SELECT wages, model_1 FROM {bvisa_blackbox_wages} WHERE wages = :wages",
          [':wages' => $bvisa_demograpics_wages, ]);
      $result  = $query->fetchAssoc();

      $bvisa_blackbox_score_wages_score = $result["model_1"];
      $bvisa_blackbox_score_wages_value = $result["wages"];

      $build['#blackbox']['wages']['score'] = $bvisa_blackbox_score_wages_score;
      $build['#blackbox']['wages']['value'] = $bvisa_blackbox_score_wages_value;

      ## Black Box Total

      $bvisa_blackbox_total_score = $bvisa_blackbox_score_age_score + $bvisa_blackbox_score_education_score + $bvisa_blackbox_score_employment_score +
$bvisa_blackbox_score_ethnicity_score + $bvisa_blackbox_score_family_score + $bvisa_blackbox_score_nationality_score+ $bvisa_blackbox_score_religion_score +
$bvisa_blackbox_score_sex_score + $bvisa_blackbox_score_sexuality_score + $bvisa_blackbox_score_wages_score;

      $build['#blackbox']['total'] = $bvisa_blackbox_total_score;

      // Must get USER uid and pass to $query



      // dump($data);
      // Move the initial query above towards the start
      // Set the blackbox queries using the answers from specific questions
      // i.e. $bvisa_demograpics_wages = $data["age question"];



      //loop through all of the questions/options from the webform
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

//              dump($node);

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
              // or maybye
              // $build['#response_options'][$key]['question']['#markup'] = $key;
      }


      $build['#theme'] = 'bvisa_results_page';
      $build['#test'] = 'Test Test Test';

       //  dump($build);

       return $build;

  }


  /**
   * B Visa Feedback Page
   */

  public function bvisa_feedback_page() {

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }

      $my_webform_machinename = 'bvisa_user_feedback';
      $my_form = \Drupal\webform\Entity\Webform::load($my_webform_machinename);

      $build = [
          '#type' => 'webform',
          '#webform' => $my_form,
      ];

      return $build;

  }


  /**
   * B Visa Follow Up Page
   */

  public function bvisa_follow_up_page() {

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }

      $my_webform_machinename = 'bvisa_user_followup';
      $my_form = \Drupal\webform\Entity\Webform::load($my_webform_machinename);

      $build = [
          '#type' => 'webform',
          '#webform' => $my_form,
      ];

      return $build;

  }



  /**
   * B Visa More Information Page
   */

  public function bvisa_more_information_page() {

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }

      $value = "bvisa_more_information_page";

      $query = \Drupal::entityQuery('node');
      $query->condition('type', 'ovr_pages');
      $query->condition('field_ovr_pages_page_id', $value);
      $nid = $query->execute();

      $node = Node::load($nid[key($nid)]);

      $title = $node->get('title')->value;
      $body = $node->get('body')->value;

      $build = [
          '#theme' => 'bvisa_more_info_page',
          '#title' => $title,
          '#body' => [
              '#type' => 'markup',
              '#markup' => $body,
          ],
      ];

      return $build;

  }


  /**
   * B Visa Submit Now Page
   */

  public function bvisa_submit_now_page() {

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }


      $value = "bvisa_submit_now_page";

      $query = \Drupal::entityQuery('node');
      $query->condition('type', 'ovr_pages');
      $query->condition('field_ovr_pages_page_id', $value);
      $nid = $query->execute();

      $node = Node::load($nid[key($nid)]);

      $title = $node->get('title')->value;
      $body = $node->get('body')->value;

      $build = [
          '#theme' => 'bvisa_submit_now_page',
          '#title' => $title,
          '#body' => [
              '#type' => 'markup',
              '#markup' => $body,
          ],
      ];

      return $build;

  }

  /*
   * B Visa Required DS160 Questions
   */


  public function bvisa_ds160_required_questions(){

      $user_check = \Drupal::service('bvisa.usercheck')->getUserCheck();

      if($user_check==FALSE)
      {
          $redirectURL = 'projects/usa/b-visa/discovery';
          return new RedirectResponse(base_path().$redirectURL);
      }

      $my_webform_machinename = 'bvisa_required';
      $my_form = \Drupal\webform\Entity\Webform::load($my_webform_machinename);

      $build = [
          '#type' => 'webform',
          '#webform' => $my_form,
      ];

      return $build;
 }

}
