include config.mk

SRC_DIR = src
BUILD_DIR = build

CONFIGBUILD = sed 's/{BOTNICK}/$(BOT_NICK)/' | sed 's/{SERVERHOST}/$(SERVER_HOST)/' | sed 's/{SERVERPORT}/$(SERVER_PORT)/' > $(BUILD_DIR)/config.php

install: config buildconfig
uninstall: clean

config:
ifeq (, $(and $(BOT_NICK),$(SERVER_HOST),$(SERVER_PORT)))
	@@echo 'incomplete config.mk' >&2 
	@@false
endif

buildconfig:
	@@mkdir -p $(BUILD_DIR)
	@@cat ${SRC_DIR}/config-template.php | $(CONFIGBUILD)

clean:
	@@rm -R $(BUILD_DIR)/*
