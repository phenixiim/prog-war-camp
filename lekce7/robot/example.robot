*** Settings ***
Library  Selenium2Library
Suite Setup     Open Browser    ${URL}   ${BROWSER}
Suite Teardown  Close All Browsers


*** Variables ***
${URL}              http://localhost:8082/lekce3/neco.html
${BROWSER}          Chrome
${hideButtonId}     myButton1
${replaceButtonId}     myButton2
${h2Id}     h2
${h2TextAfterReplacing}     nahrazeniH2


*** Test Cases ***
Perform test for lekce3 - neco.html function
    Sleep   2s
    Wait Until Element Is Visible  ${hideButtonId}
    Click Element  ${hideButtonId}
    Sleep   2s
    Wait Until Element Is Visible  ${replaceButtonId}
    Click Element  ${replaceButtonId}
    Sleep   2s
    Element Should Be Visible   ${h2Id}
    Element Should Contain  ${h2Id}  ${h2TextAfterReplacing}
    Sleep   2