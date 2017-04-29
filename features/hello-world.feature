Feature: We can make requests and inspect the responses

  Scenario: Trivial PSR-7 app can be queried
    When I go to "?name=Ciaran"
    Then I should see "Hello Ciaran"
