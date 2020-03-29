describe('anonymous workflow', function () {
  beforeEach(function () {
    Cypress.Cookies.preserveOnce('PHPSESSID');
  });
  it('go to thing list', function () {
    cy.visit('http://localhost');
    cy.get('a.nav-link:contains("Bedarf")').click();
    cy.title().should('eq', 'print4health - Bedarf & Ersatzteile');
    cy.wait(500);
  });
  it('go to thing detail page', function () {
    cy.get('h5:contains("COVID-19 MASK")').click();
    cy.title().should('eq', 'print4health - Bedarf / COVID-19 MASK');
  });
  it('open order modal', function () {
    cy.get('.fa-plus-circle.text-primary').click();
    cy.wait(500);
    cy.contains('Bedarf für "COVID-19 MASK" eintragen');
  });
  it('check order modal displays only info text', function () {
    cy.get('input[value=OK]').click();
    cy.wait(500);
  });
  it('click map marker', function () {
    cy.get('.map-marker-order i').first().click();
    cy.get('.leaflet-popup-content').contains('Herstellung zusagen');
    cy.wait(500);
  });
  it('click commit button', function () {
    cy.get('a.btn:contains("Herstellung zusagen")').click();
    cy.wait(500);
  });
  it('check commit modal displays only info text', function () {
    cy.get('input[value=OK]').click();
    cy.wait(500);
  });
});
