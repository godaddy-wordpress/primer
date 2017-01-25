# MakeFile for building all the docs at once.
# Inspired by the Makefile used by bazaar.
# http://bazaar.launchpad.net/~bzr-pqm/bzr/2.3/

PYTHON = python
ES_HOST =

.PHONY: all clean html htmlhelp website website-dirs rebuild-index

# Languages that can be built.
# LANGS = en es fr ja pt zh tr
LANGS = en

DEST = website

# Dependencies to perform before running other builds.
# Clone the en/Makefile everywhere.
SPHINX_DEPENDENCIES = $(foreach lang, $(LANGS), $(lang)/Makefile)

# Copy-paste the English Makefile everywhere it's needed (if non existing).
%/Makefile: en/Makefile
	cp -n $< $@

#
# The various formats the documentation can be created in.
#
# Loop over the possible languages and call other build targets.
#
html: $(foreach lang, $(LANGS), html-$(lang))
htmlhelp: $(foreach lang, $(LANGS), htmlhelp-$(lang))
latex: $(foreach lang, $(PDF_LANGS), latex-$(lang))
htmlhelp: $(foreach lang, $(LANGS), htmlhelp-$(lang))
populate-index: $(foreach lang, $(LANGS), populate-index-$(lang))
server: $(foreach lang, $(LANGS), server-$(lang))
rebuild-index: $(foreach lang, $(LANGS), rebuild-index-$(lang))


# Make the HTML version of the documentation with correctly nested language folders.
html-%: $(SPHINX_DEPENDENCIES)
	cd $* && make html LANG=$*
	make build/html/$*/_static/css/app.css
	make build/html/$*/_static/app.js

htmlhelp-%: $(SPHINX_DEPENDENCIES)
	cd $* && make htmlhelp LANG=$*

latex-%: $(SPHINX_DEPENDENCIES)
	cd $* && make latex LANG=$*

server-%: $(SPHINX_DEPENDENCIES)
	cd build/html/$* && python -m SimpleHTTPServer

populate-index-%: $(SPHINX_DEPENDENCIES)
	php scripts/populate_search_index.php $* $(ES_HOST)

rebuild-index-%: $(SPHINX_DEPENDENCIES)
	curl -XDELETE $(ES_HOST)/documentation/3-0-$*
	php scripts/populate_search_index.php $* $(ES_HOST)

website-dirs:
	# Make the directory if its not there already.
	[ ! -d $(DEST) ] && mkdir $(DEST) || true

	# Make the downloads directory
	[ ! -d $(DEST)/_downloads ] && mkdir $(DEST)/_downloads || true

	# Make downloads for each language
	$(foreach lang, $(LANGS), [ ! -d $(DEST)/_downloads/$(lang) ] && mkdir $(DEST)/_downloads/$(lang) || true;)

website: website-dirs html populate-index
	# Move HTML
	$(foreach lang, $(LANGS), cp -r build/html/$(lang) $(DEST)/$(lang);)

clean:
	rm -rf build/*

clean-website:
	rm -rf $(DEST)/*

build/html/%/_static:
	mkdir -p build/html/$*/_static

CSS_FILES = themes/godaddy/static/css/fonts.css \
  themes/godaddy/static/css/bootstrap.min.css \
  themes/godaddy/static/css/font-awesome.min.css \
  themes/godaddy/static/css/style.css \
  themes/godaddy/static/css/default.css \
  themes/godaddy/static/css/pygments.css \
  themes/godaddy/static/css/responsive.css

build/html/%/_static/css/app.css: build/html/%/_static $(CSS_FILES)
	# echo all dependencies ($$^) into the output ($$@)
	cat $(CSS_FILES) > $@

JS_FILES = themes/godaddy/static/jquery.js \
  themes/godaddy/static/vendor.js \
  themes/godaddy/static/app.js \
  themes/godaddy/static/search.js \
  themes/godaddy/static/typeahead.js

build/html/%/_static/app.js: build/html/%/_static $(JS_FILES)
	# echo all dependencies ($JS_FILES) into the output ($$@)
	cat $(JS_FILES) > $@
