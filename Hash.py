# Script creates a Hashmap object

class Hash:
    # The maximum elements, m, in the Hashmap is defined when the class is instantiated
    def __init__(self, m):
        self.array = [0]*m
        self.size = 0
        self.max = m

    # ___Hash Functions___
    # The modulos ensure that the numbers don't exceed a certain range
    
    # The first hash function bitwise or's every letter in the given string and squares it
    def convertA(self, string, conv=0):
        for s in string:
            conv = (conv ^ (ord(s)-97))**2 % 1000000
        return conv
    
    # The second hash function bitwise or's the square of every letter in the given string
    def convertB(self, string, conv=0):
        for s in string:
            conv = (conv ^ ord(s)**2) % 1000000
        return conv

    # hash_function will produce the hash for the given string using double hashing
    def hash_function(self, file_name, i):
        A = (self.convertA(file_name) + i*self.convertB(file_name)) % self.max
        # 0 is treated as a empty position, therefore the hash function should not return 0
        if (A == 0):
            return 1
        return A


    # ___Hashmap Methods___

    # Generates a unique hash for a string
    def generate(self, file_name):
        if (self.size < self.max):
            for i in range(self.max):
                A = self.hash_function(file_name, i)
                if (self.array [A] == 0 or self.array [A] == -1):
                    self.array [A] = file_name
                    self.size += 1
                    return A
                elif (self.array [A] == file_name):
                    print("ERROR: Duplicate file input")
                    return -1
        print("ERROR: Hash full")
        return -1

    # Deletes the hash for a string
    def delete(self, file_name):
        if (self.size > 0):
            for i in range(self.max):
                A = self.hash_function(file_name, i)
                if (self.array [A] == 0 or self.array [A] == -1):
                    print("ERROR: File not found")
                    return -1
                elif (self.array [A] == file_name):
                    self.array [A] = -1
                    self.size -= 1
                    return 0
        print("ERROR: Hash empty")
        return -1

    # Searches for the hash of a string
    def search(self, file_name):
        for i in range(self.max):
            A = self.hash_function(file_name, i)
            if (self.array [A] == 0):
                print("ERROR: File not found")
                return -1
            elif (self.array [A] == file_name):
                break
        if (i < self.max):
            return A
        print("ERROR: File not found")
        return -1

    # Prints the entire Hashmap
    def print_hash(self):
        print(self.array)

