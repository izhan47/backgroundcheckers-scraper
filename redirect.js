const puppeteer = require("puppeteer");

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();

  await page.goto("https://www.backgroundcheckers.net/");
  console.log("Redirected to https://www.backgroundcheckers.net/");

  await page.setViewport({ width: 1080, height: 1024 });
  await page.type("#firstName", "M");
  await page.type("#lastName", "Izhan");
  await page.select('#state', 'all');

  const searchResultSelector = "#perform-search";

  await page.waitForSelector(searchResultSelector);
  await page.click(searchResultSelector);

  const resultsSelector = ".row.results-list";

  // Wait for the results to be visible
  await page.waitForSelector(resultsSelector);

  // Extract name, age, location, and relatives
  const results = await page.evaluate(async () => {
    const elements = document.querySelectorAll('.row.results-list .row.searchedPerson');
    const results = [];
    for (const element of elements) {
      const name = element.querySelector('h3').textContent.trim();
      const age = element.querySelector('h4').textContent.trim().replace('Age: ', '');
      
      // Click the "See More" button for relatives if it exists
      const relativesElement = element.querySelector('.col-sm-2:nth-child(2)');
      const relativesSeeMoreLink = relativesElement.querySelector('a.more');
      if (relativesSeeMoreLink) {
        relativesSeeMoreLink.click();
        await new Promise(resolve => setTimeout(resolve, 3000)); // Wait for the relatives to load (adjust as needed)
      }
      const relativesText = relativesElement.textContent.trim().replace('Possible relatives: ', '');
      const relatives = relativesText.split(',').map(rel => rel.trim());
      
      // Click the "See More" button for locations if it exists
      const locationElement = element.querySelector('.col-sm-2:nth-child(3)');
      const locationSeeMoreLink = locationElement.querySelector('a.more');
      if (locationSeeMoreLink) {
        locationSeeMoreLink.click();
        await new Promise(resolve => setTimeout(resolve, 3000)); // Wait for the locations to load (adjust as needed)
      }
      const location = locationElement.textContent.trim().replace('Locations: ', '');
      
      results.push({ name, age, location, relatives });
    }
    return results;
  });

  // Log all the records
  console.log(results);

  await browser.close();
})();
