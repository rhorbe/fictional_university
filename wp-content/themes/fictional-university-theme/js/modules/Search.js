"use strict";

import $ from "jquery";
const KEY_S_CODE = 83;
const KEY_ESC_CODE = 27;

class Search {
  constructor() {
    this.document = $(document);
    this.body = $("body");
    this.addSearchHTML();

    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue = "";
    this.typingTimer = null;

    this.resultsDiv = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");

    this.setEvents();
  }

  setEvents() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    this.document.on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  openOverlay() {
    this.activateOvelay();
    this.disableBodyScrolling();
    this.clearSearchField();
    this.focusSearchField();
    this.isOverlayOpen = true;
    return false; // esto evita el comportamiento predeterminado
  }

  activateOvelay() {
    this.searchOverlay.addClass("search-overlay--active");
  }

  disableBodyScrolling() {
    this.body.addClass("body-no-scroll");
  }

  clearSearchField() {
    this.searchField.val("");
  }

  focusSearchField() {
    setTimeout(() => {
      this.searchField.trigger("focus");
    }, 301);
  }

  closeOverlay() {
    this.stopWaitTimerThatStartsSearch();
    this.clearOverlayBody();
    this.deactivateOverlay();
    this.enableBodyScrolling();
    this.isOverlayOpen = false;
  }

  deactivateOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
  }

  enableBodyScrolling() {
    this.body.removeClass("body-no-scroll");
  }

  clearOverlayBody() {
    this.resultsDiv.html("");
  }

  keyPressDispatcher(evento) {
    if (
      evento.keyCode == KEY_S_CODE &&
      !this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    ) {
      this.openOverlay();
    }

    if (evento.keyCode == KEY_ESC_CODE && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }

  typingLogic() {
    if (this.searchFieldHasChanged()) {
      this.stopWaitTimerThatStartsSearch();
      if (this.searchFieldHasText()) {
        this.showSpinner();
        this.startSearchIn(750);
      } else {
        this.hideSpinner();
      }
    }
    this.previousValue = this.searchField.val();
  }

  searchFieldHasChanged() {
    return this.searchField.val() != this.previousValue;
  }

  stopWaitTimerThatStartsSearch() {
    clearTimeout(this.typingTimer);
  }

  searchFieldHasText() {
    return this.searchField.val() != "";
  }

  showSpinner() {
    if (!this.isSpinnerVisible) {
      this.resultsDiv.html('<div class="spinner-loader"></div>');
      this.isSpinnerVisible = true;
    }
  }

  hideSpinner() {
    this.resultsDiv.html("");
    this.isSpinnerVisible = false;
  }

  startSearchIn(timeInMilliseconds) {
    this.typingTimer = setTimeout(() => this.search, timeInMilliseconds);
  }

  search() {
    const $searchURL = `http://localhost/wordpress/wp-json/university/v1/search?term=${this.searchField.val()}`;
    $.getJSON($searchURL, this.showSearchResults.bind(this));
  }

  errorsManager(error) {
    console.log(error);
  }

  showSearchResults(results) {
    this.hideSpinner();
    const resultsBody = `
      <div class="row">
        <div class="one-third">
          <h2 class="search-overlay__section-title">General Information</h2> 
          ${
            this.areThereResults(results.generalInfo)
              ? this.getResultsItems(results.generalInfo)
              : "<p>No matches.</p>"
          }
        </div>
        <div class="one-third">
          <h2 class="search-overlay__section-title">Programs</h2>
          ${
            this.areThereResults(results.programs)
              ? this.getResultsItems(results.programs)
              : "<p>No matches.</p>"
          }
          <h2 class="search-overlay__section-title">Professors</h2>
          ${
            this.areThereResults(results.professors)
              ? this.getResultsProfessorsItems(results.professors)
              : "<p>No matches.</p>"
          }
        </div>
        <div class="one-third">
          <h2 class="search-overlay__section-title">Campuses</h2>
          ${
            this.areThereResults(results.campuses)
              ? this.getResultsItems(results.campuses)
              : "<p>No matches.</p>"
          }
          <h2 class="search-overlay__section-title">Events</h2>
          ${
            this.areThereResults(results.events)
              ? this.getResultsEventsItems(results.events)
              : "<p>No matches.</p>"
          }
        </div>
      </div>
      `;

    this.resultsDiv.html(resultsBody);
  }

  getResultsItems(results) {
    let resultsItems = "";
    if (this.areThereResults(results)) {
      resultsItems = results
        .map(
          (item) =>
            `<li> <a href="${item.permalink}">${item.title}</a>${
              item.postType == "post" ? ` by ${item.authorName}` : ""
            }</li>`
        )
        .join("");
    }
    return '<ul class="link-list min-list">' + resultsItems + "</ul>";
  }

  getResultsProfessorsItems(results) {
    let resultsItems = "";
    if (this.areThereResults(results)) {
      resultsItems = results
        .map(
          (item) => `
          <li class="professor-card__list-item">
              <a class="professor-card" href="${item.permalink}">
                  <img src="${item.image}" alt="imagen del profesor" class="professor-card__image">
                  <span class="professor-card__name">
                      <${item.title}>
                  </span>
              </a>
          </li>
          `
        )
        .join("");
    }
    return '<ul class="link-list min-list">' + resultsItems + "</ul>";
  }

  getResultsEventsItems(results) {
    let resultsItems = "";
    if (this.areThereResults(results)) {
      resultsItems = results
        .map(
          (item) => `          
          <div class="event-summary">
          <a class="event-summary__date event-summary__date t-center" href="${item.permalink}">
              <span class="event-summary__month">${item.month}</span>
              <span class="event-summary__day">${item.day}</span>
          </a>
          <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
              <p>${item.description}
                  <a href="${item.permalink}" class="nu gray">Seguir leyendo</a>
              </p>
          </div>
      </div>


          `
        )
        .join("");
    }
    return '<ul">' + resultsItems + "</ul>";
  }

  areThereResults(results) {
    return results.length > 0;
  }

  addSearchHTML() {
    this.body.append(`
    <div class="search-overlay">
      <div class="search-overlay__top">
        <div class="container">
          <i class="fa fa-search search-overlay__icon search-overlay--active" aria-hidden="true"></i>
          <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
          <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
      </div>

    <div class="container">
      <div id="search-overlay__results"></div>
    </div>
    `);
  }
}

export default Search;
