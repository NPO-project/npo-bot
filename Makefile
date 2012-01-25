include config.mk

SRC_DIR = src
BUILD_DIR = build
DIST_DIR = dist

CONFIGBUILD = sed 's/{BOTNICK}/$(BOT_NICK)/' | sed 's/{SERVERHOST}/$(SERVER_HOST)/' | sed 's/{SERVERPORT}/$(SERVER_PORT)/' > $(DIST_DIR)/config.php

install: config createdirectories buildconfig
uninstall: clean

config:
ifeq (, $(and $(BOT_NICK),$(SERVER_HOST),$(SERVER_PORT)))
	@@echo 'incomplete config.mk' >&2 
	@@false
endif

createdirectories:
	@@mkdir -p $(DIST_DIR)
	@@mkdir -p $(BUILD_DIR)

buildconfig:
	@@cat ${SRC_DIR}/config-template.php | $(CONFIGBUILD)

clean:
	@@rm -R $(BUILD_DIR)/*
