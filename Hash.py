class Hash:
    def __init__(self, m):
        self.array = [0]*m
        self.size = 0
        self.max = m

    def convertA(self, string, conv=0):
        for s in string:
            conv = (conv ^ (ord(s)-97))**2 % 1000000
        return conv
    
    def convertB(self, string, conv=0):
        for s in string:
            conv = (conv ^ ord(s)**2) % 1000000
        return conv


    def hash_function(self, file_name, i):
        A = (self.convertA(file_name) + i*self.convertB(file_name)) % self.max
        if (A == 0):
            return 1
        return A

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

    def print_hash(self):
        print(self.array)

