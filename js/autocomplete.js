(function() {

  const courseSearch = document.querySelector(".puffin-autocomplete");
  const courseFinder = document.querySelector("#courseFinder");
  const courseFinderDropdown = document.querySelector("#courseFinderDropdown");

  let timeout;
  courseSearch.addEventListener('input', (event) => {

    //Popper adds a load of annoying inline styles we need to get rid of.
    gsap.set(courseFinderDropdown, {
      clearProps: true,
    });

    clearTimeout(timeout);
    timeout = setTimeout(() => {
      if (courseSearch.value.length > 2) {
        courseFinder.classList.add("loading");
        getAutocomplete(courseSearch.value);
      } else {
        animFadeOut("#courseFinderDropdown");
      }
    }, 500);
  });

  async function getAutocomplete(value) {
    const response = await fetch(courseSearch.dataset.puffinAutocompletePath + "?" + new URLSearchParams({
      q: courseSearch.value,
    }));
    const jsonData = await response.json();
    courseFinder.classList.remove("loading");

    if (jsonData.length < 1) {
      animFadeOut("#courseFinderDropdown");
      return;
    }

   //TODO: add callback option to ANIM library ()


    courseFinderDropdown.innerHTML = "";
    courseFinderDropdown.classList.add("show");
    animFadeIn("#courseFinderDropdown");

    jsonData.forEach(element => {
      const li = document.createElement("li");
      let query = courseSearch.value;
      result = element.title.replace(new RegExp(query, "gi"), `<b>${query}</b>`);
      const link = document.createElement("a");
      link.classList.add("dropdown-item");
      link.href = element.url;

      link.innerHTML = result;
      li.appendChild(link);
      courseFinderDropdown.appendChild(li);
    });
  }

})();

