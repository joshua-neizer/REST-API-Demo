#!/usr/bin/env python

import pickle
import sys
from Hash import Hash

hashID = pickle.load( open( "/home/pi/code/MY_API/data/hash_map.p", "rb" ) )

print(hashID.search((sys.argv [1])))
