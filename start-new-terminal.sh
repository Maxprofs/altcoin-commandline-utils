#!/bin/bash
#sleep 10
#xterm -title 'Mining Profit @ 1KH/s' -geometry 80x10+0+0 -e 'watch -n60 ~/apis/profit.php ITNS,XUN,BCN'  &
gnome-terminal --title 'Mining Profit @ 1KH/s' --hide-menubar --geometry=80x10+0+0 -x bash -c 'watch -n60 php profit.php ITNS,XUN,BCN,XMR'
#sleep 5
#xterm -title 'Stocks.Exchange Buy/Sell' -geometry 80x20+200+0 -e 'watch -n60 ~/apis/getPrice.php ITNS_BTC,XUN_BTC,BCN_BTC' &
gnome-terminal --title 'Stocks.Exchange Buy/Sell' --hide-menubar --geometry=80x20+0+220 -x bash -c 'watch -n60 php getPrice.php ITNS_BTC,XUN_BTC,BCN_BTC'
