package main

import (
	"bytes"
	_ "encoding/json"
	"fmt"
	"os/exec"
	"path/filepath"
	"runtime"
	"strconv"
	"strings"
	"time"
)

struct ChannelRunItem{

}

func getItem() (*ChannelRunItem, error) {
	cri := new ChannelRunItem{}
}

func begin(dataChan chan *ChannelRunItem) {
	for {
		select {
		case runItem:= <-dataChan:
			doWithChannelItem(runItem)
		default:
			time.Sleep(1000 * time.Millisecond)
		}
	}
}

func main() {

	np := runtime.NumCPU()
	runtime.GOMAXPROCS(np)
	runtime.Gosched()

	dataChan := make(chan *lm.DownloadInfoWriteRedis, np)
	for i := 0; i < np; i++ {
		go begin(dataChan)
	}

	flag := true
	var item *ChannelRunItem
	var err error
	for {
		if flag {
			item, err = getItem()
			flag = false
		}
		if nil == err {
			select {
			case dataChan <- item:
				flag = true
			default:
				time.Sleep(1000 * time.Millisecond)
			}
		} else {
			flag = true
		}
	}
}
