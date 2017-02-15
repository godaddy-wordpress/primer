# MakeFile for building all the docs at once.
# Inspired by the Makefile used by bazaar.
# http://bazaar.launchpad.net/~bzr-pqm/bzr/2.3/

PYTHON = python
ES_HOST =

.PHONY: all clean html website

# Languages that can be built.
# LANGS = en es fr ja pt zh tr
LANGS = en

# Dependencies to perform before running other builds.
# Clone the en/Makefile everywhere.
SPHINX_DEPENDENCIES = $(foreach lang, $(LANGS), $(lang)/Makefile)

# Copy-paste the English Makefile everywhere it's needed (if non existing).
%/Makefile: Makefile
	cp -n sphinx/src/makefile sphinx/src/makefile

#
# The various formats the documentation can be created in.
#
# Loop over the possible languages and call other build targets.
#
html:
	cd sphinx/src && make html
	make build/html/_static/css/app.css
	make build/html/_static/app.js

clean:
	rm -rf build/*

build/html/_static:
	mkdir -p build/html/_static

CSS_FILES = sphinx/godaddy/static/css/fonts.css \
  sphinx/godaddy/static/css/bootstrap.min.css \
  sphinx/godaddy/static/css/font-awesome.min.css \
  sphinx/godaddy/static/css/style.css \
  sphinx/godaddy/static/css/default.css \
  sphinx/godaddy/static/css/pygments.css \
  sphinx/godaddy/static/css/responsive.css

build/html/_static/css/app.css: build/html/_static $(CSS_FILES)
	# echo all dependencies ($$^) into the output ($$@)
	cat $(CSS_FILES) > $@

JS_FILES = sphinx/godaddy/static/jquery.js \
  sphinx/godaddy/static/vendor.js \
  sphinx/godaddy/static/app.js \
  sphinx/godaddy/static/search.js \
  sphinx/godaddy/static/typeahead.js

build/html/_static/app.js: build/html/_static $(JS_FILES)
	# echo all dependencies ($JS_FILES) into the output ($$@)
	cat $(JS_FILES) > $@
