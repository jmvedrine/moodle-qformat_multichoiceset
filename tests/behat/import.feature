@qformat @qformat_multichoiceset
Feature: Test importing questions with multichoiceset to change question type
  In order to reuse some of my multichoice questions
  As a teacher
  I need to be able to import them as all or nothing multichoice questions.

  Background:
    Given the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "users" exist:
      | username | firstname |
      | teacher  | Teacher   |
    And the following "course enrolments" exist:
      | user    | course | role           |
      | teacher | C1     | editingteacher |
    And I log in as "teacher"
    And I follow "C1"

  @javascript @_file_upload
  Scenario: import XML file
    When I navigate to "Import" node in "Course administration > Question bank"
    And I set the field "id_format_multichoiceset" to "1"
    And I upload "question/format/multichoiceset/tests/fixtures/multichoice.xml" file to "Import" filemanager
    And I press "id_submitbutton"
    Then I should see "Parsing questions from import file."
    And I should see "Importing 1 questions from file"
    When I press "Continue"
    Then I should see "Multi-choice-001"
    And I click on "Edit" "link" in the "Multi-choice-001" "table_row"
    And I should not see "Editing a Multiple choice question"
    And I should see "Editing an All-or-Nothing Multiple Choice Question"
    
