Feature: We can make requests and inspect the responses

  Scenario: PSR-7 app can be queried
    When I go to "?name=Ciaran"
    Then I should see "Hello Ciaran"
